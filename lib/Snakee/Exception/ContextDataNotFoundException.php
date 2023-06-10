<?php

namespace Flawless\Snakee\Exception;

use Exception;

class ContextDataNotFoundException extends Exception
{
    public function __construct(string $key)
    {
        parent::__construct("Context data not found at key $key");
    }
}
