<?php

namespace App\Endpoint\Test;

use Flawless\Http\Application\HttpApplication;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;

class OneHandler implements EndpointHandlerInterface
{
    public function __construct(
        private HttpApplication $application,
    ) {
    }

    public function handle(Request $request): ResponseInterface
    {
        dd($this->application);
        return new Response('1!');
    }
}
