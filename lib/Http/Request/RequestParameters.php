<?php

namespace Flawless\Http\Request;

class RequestParameters
{
    public function __construct(
        private array $data = []
    ) {
    }

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function all(): array
    {
        return $this->data;
    }
}
