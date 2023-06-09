<?php

namespace App\Service\Test;


use Flawless\Container\ContainerInterface;

class HelloService
{
    public function __construct(
        private string $name,
        private ContainerInterface $container,
    ) {
    }

    public function hello(): string
    {
        return $this->name;
    }
}
