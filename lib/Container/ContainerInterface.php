<?php

namespace Flawless\Container;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    public function bind(string $id, string $actualId);

    public function register(string $id, $value);
}
