<?php

namespace Flawless\Container;

use Flawless\Container\Exception\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $objects = [];

    public function get(string $id)
    {
        return $this->objects[$id] ?? $this->prepareObject($id);
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
        $this->objects[$id] = $value;
    }

    public function prepareObject(string $id)
    {
        if (!class_exists($id)) {
            throw new ContainerException("Not found object $id");
        }

        $reflection = new ReflectionClass($id);
        $constructorParameters = $reflection->getConstructor()?->getParameters() ?? [];

        $constructorParameters = array_map(
            fn(ReflectionParameter $parameter) => $this->get($parameter->getType()->getName()),
            $constructorParameters
        );

        $object = new $id(...$constructorParameters);
        $this->register($id, $object);
        return $object;
    }
}
