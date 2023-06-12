<?php

namespace Flawless\Http\Request;

class Request
{
    private RequestParameters $query;

    private RequestParameters $headers;

    public function __construct(
        private string $method,
        private string $uri,
        private ?string $body = null,
        array $query = [],
        array $headers = [],
    ) {
        $this->query = new RequestParameters($query);
        $this->headers = new RequestParameters($headers);
    }

    public static function fromGlobals(): self
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $uri = strtok($uri, '?');
        return new Request($method, $uri, file_get_contents('php://input'), $_GET, getallheaders());
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getQuery(): RequestParameters
    {
        return $this->query;
    }

    public function getHeaders(): RequestParameters
    {
        return $this->headers;
    }

    public function getBody(): string|null
    {
        return $this->body;
    }

    public function getJsonBody(): array
    {
        return json_decode($this->body, true);
    }
}
