<?php

namespace App\Snakee\Middleware;

use Flawless\Http\Request\Request;
use Flawless\Http\Snakee\BaseRequestMiddleware;

class RequestContextMiddleware extends BaseRequestMiddleware
{
    protected function getRequestData(Request $request): array
    {
        return [
            'num' => $request->getQuery()->get('num'),
        ];
    }
}
