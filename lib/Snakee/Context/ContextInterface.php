<?php

namespace Flawless\Snakee\Context;

interface ContextInterface
{
    public function safeGet(string $key, $default = null);

    public function get(string $key);

    public function set(string $key, $value): self;

    public function clear(string $key): self;

    public function setObject(object $object);

    public function all(): array;
}
