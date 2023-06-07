<?php

namespace Flawless\Container;

use ReflectionClass;

class ContainerBuilder
{
    public function build(array $classes): Container
    {
        return new Container();
    }

    public function handleClass(string $class)
    {
        $reflection = new ReflectionClass($class);

        if ($reflection->isTrait()) {
            return;
        }
    }
}
