<?php

namespace App\Service;

class HelloService
{
    public function hello(): string
    {
        $names = [
            'man',
            'max',
            'nig',
        ];
        return $names[array_rand($names)];
    }
}
