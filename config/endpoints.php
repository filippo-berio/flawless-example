<?php

use App\Endpoint\App\CreateAppEndpointHandler;
use App\Endpoint\Endpoint\CreateEndpointHandler;
use App\Endpoint\Endpoint\RunEndpointHandler;
use App\Endpoint\Test\GraphEndpointHandler;
use App\Endpoint\Test\HelloEndpointHandler;
use App\Middleware\Test\ApiKeyMiddleware;
use Flawless\Http\FlawlessHttp;

$apiMiddleware = [
    ApiKeyMiddleware::class,
];

return [
    '/api' => [
        '/app' => [
            FlawlessHttp::endpoint('POST', '', CreateAppEndpointHandler::class),
        ],
        '/endpoint' => [
            FlawlessHttp::endpoint('POST', '', CreateEndpointHandler::class),
        ],
    ],
    FlawlessHttp::endpoint('GET', '/run', RunEndpointHandler::class),
    '/test' => [
        FlawlessHttp::endpoint('GET', '/hello', HelloEndpointHandler::class)->withMiddleware($apiMiddleware),
        FlawlessHttp::endpoint('GET','/graph', GraphEndpointHandler::class),
    ],
];
