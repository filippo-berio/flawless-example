<?php

namespace Flawless\Container;

use Flawless\Container\Exception\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $parameters = [];

    public function get(string $id)
    {
        return $this->parameters[$id] ?? $this->prepareObject($id);
    }

    public function has(string $id): bool
    {
        try {
            return !!$this->get($id);
        } catch (ContainerException) {
            return false;
        }
    }

    public function register(string $id, $value)
    {
        $this->parameters[$id] = $value;
    }

    private function prepareObject(string $id)
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
