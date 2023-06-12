<?php

namespace App\Middleware\Test;

use Exception;
use Flawless\Http\Middleware\MiddlewareInterface;
use Flawless\Http\Request\Request;

class RandomErrorMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): Request
    {
        $rand = rand(0, 10);
        if ($rand < 4) {
            throw new Exception('Service randomly broke');
        }
        return $request;
    }
}
