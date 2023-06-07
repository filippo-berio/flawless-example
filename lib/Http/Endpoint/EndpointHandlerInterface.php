<?php

namespace Flawless\Http\Endpoint;

use Flawless\Http\Request\Request;
use Flawless\Http\Response\ResponseInterface;

interface EndpointHandlerInterface
{
    public function handle(Request $request): ResponseInterface;
}
