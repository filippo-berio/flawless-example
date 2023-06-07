<?php

namespace App\Endpoint;

use App\Service\HelloService;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;

class HelloEndpointHandler implements EndpointHandlerInterface
{
    public function __construct(
        protected HelloService $helloService,
    ) {
    }

    public function handle(Request $request): ResponseInterface
    {
        $name = $this->helloService->hello();
        return new Response('Hello  ' . $name);
    }
}
