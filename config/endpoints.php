<?php

use App\Endpoint\HelloEndpointHandler;
use App\Endpoint\OneHandler;
use App\Endpoint\TwoHandler;
use App\Middleware\ApiKeyMiddleware;
use Flawless\Http\FlawlessHttp;

$apiMiddleware = [
    ApiKeyMiddleware::class,
];

return [
    FlawlessHttp::endpoint('GET', '/hello', HelloEndpointHandler::class),
    '/api' => [
        '/v1' => [
            FlawlessHttp::endpoint('GET', '/one', OneHandler::class)
                ->withMiddleware($apiMiddleware),
            FlawlessHttp::endpoint('GET', '/two', TwoHandler::class)
                ->withMiddleware($apiMiddleware),
        ]
    ]
];
