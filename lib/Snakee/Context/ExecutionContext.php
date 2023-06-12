<?php

namespace Flawless\Snakee\Context;

use Flawless\Snakee\Exception\ContextDataNotFoundException;

class ExecutionContext implements ContextInterface
{
    public function __construct(
        protected array $data = [],
    ) {
    }

    public function safeGet(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function get(string $key)
    {
        if (!isset($this->data[$key])) {
            throw new ContextDataNotFoundException($key);
        }
        return $this->data[$key];
    }

    public function set($key, $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function clear(string $key): self
    {
        unset($this->data[$key]);
        return $this;
    }

    public function setObject(object $object): self
    {
        $this->data[$object::class] = $object;
        return $this;
    }

    public function all(): array
    {
        return $this->data;
    }
}
