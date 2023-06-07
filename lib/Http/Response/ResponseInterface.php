<?php

namespace Flawless\Http\Response;

interface ResponseInterface
{
    public function getContentType(): string;

    public function getBody();

    public function getStatusCode(): int;
}
