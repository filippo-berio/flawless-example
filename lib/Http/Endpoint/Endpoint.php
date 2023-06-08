<?php

namespace Flawless\Http\Endpoint;

class Endpoint
{
    public array $middlewares = [];

    public function __construct(
        public string $method,
        public string $uri,
        public string $handlerClass,
    ) {
    }

    public function addPrefix(string $prefix): self
    {
        $this->uri = $prefix . $this->uri;
        return $this;
    }

    public function withMiddleware(array $middlewares): self
    {
        $this->middlewares = [
            ...$this->middlewares,
            ...$middlewares
        ];
        return $this;
    }
}
