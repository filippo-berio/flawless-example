<?php

namespace Flawless\Http\Response;

class JsonResponse extends Response
{
    public function __construct(
        array $body = [],
        int $status = 200
    ) {
        parent::__construct($body, $status);
    }

    public function getContentType(): string
    {
        return 'application/json; charset=utf-8';
    }

    public function getBody()
    {
        return json_encode($this->body, 256);
    }
}
