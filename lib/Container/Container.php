<?php

namespace Flawless\Container;

use Flawless\Container\Exception\ContainerException;
use ReflectionClass;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $parameters = [];
    private array $binds = [];

    public function __construct()
    {
        $this->register($this::class, $this);
        $this->bind(ContainerInterface::class, $this::class);
    }

    public function get(string $id)
    {
        $binding = $this->binds[$id] ?? null;
        if ($binding) {
            return $this->get($binding);
        }
        return $this->parameters[$id] ?? $this->prepareService($id);
    }

    public function has(string $id): bool
    {
        try {
            return !!$this->get($id);
        } catch (ContainerException) {
            return false;
        }
    }

    public function bind(string $id, string $actualId)
    {
        $this->binds[$id] = $actualId;
    }

    public function register(string $id, $value)
    {
        $this->parameters[$id] = $value;
    }

    private function prepareService(string $id)
    {
        if (!class_exists($id)) {
            throw new ContainerException("Not found object $id");
        }

        $reflection = new ReflectionClass($id);
        $constructorParameters = $reflection->getConstructor()?->getParameters() ?? [];

        $constructorParameters = array_map(
            function (ReflectionParameter $parameter) {
                $id = $parameter->getName();
                if (!$this->has($id)) {
                    $id = $parameter->getType()->getName();
                }
                return $this->get($id);
            },
            $constructorParameters
        );

        $object = new $id(...$constructorParameters);
        $this->register($id, $object);
        return $object;
    }
}
