<?php

namespace App\Service;

class HelloService
{
    public function __construct(
        private string $name
    ) {
    }

    public function hello(): string
    {
        return $this->name;
    }
}
