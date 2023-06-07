<?php

namespace Flawless\Container\Exception;

use Exception;

class ContainerException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
