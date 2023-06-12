<?php

namespace App\Middleware\Test;

use Flawless\Http\Middleware\MiddlewareInterface;
use Flawless\Http\Request\Request;

class RequestStdoutMiddleware implements MiddlewareInterface
{

    public function handle(Request $request): Request
    {
        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout, "{$request->getMethod()}-request at {$request->getUri()}\n");
        return $request;
    }
}
