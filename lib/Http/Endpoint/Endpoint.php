<?php

namespace Flawless\Http\Endpoint;

class Endpoint
{
    public function __construct(
        public string $method,
        public string $uri,
        public string $handlerClass
    ) {
    }

    public function addPrefix(string $prefix): self
    {
        $this->uri = $prefix . $this->uri;
        return $this;
    }
}
