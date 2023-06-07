<?php

namespace App\Endpoint;

use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;

class OneHandler implements EndpointHandlerInterface
{

    public function handle(Request $request): ResponseInterface
    {
        return new Response('1!');
    }
}
