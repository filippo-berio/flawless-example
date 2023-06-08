<?php

namespace App\Middleware;

use Exception;
use Flawless\Http\Middleware\MiddlewareInterface;
use Flawless\Http\Request\Request;

class ApiKeyMiddleware implements MiddlewareInterface
{
    public function __construct(
        private string $apiKey,
    ) {
    }

    public function handle(Request $request): Request
    {
        $requestKey = $request->getQuery()->get('key');
        if ($requestKey !== $this->apiKey) {
            throw new Exception('Unauthenticated request');
        }
        return $request;
    }
}
