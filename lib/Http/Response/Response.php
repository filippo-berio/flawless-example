<?php

namespace Flawless\Http\Response;

class Response implements ResponseInterface
{
    public function __construct(
        protected $body,
        protected int $status = 200,
    ) {
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function getContentType(): string
    {
        return 'text/html; charset=utf-8';
    }
}
