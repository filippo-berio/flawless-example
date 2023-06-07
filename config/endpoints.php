<?php

use App\Endpoint\HelloEndpointHandler;
use App\Endpoint\OneHandler;
use App\Endpoint\TwoHandler;
use Flawless\Http\FlawlessHttp;

return [
    FlawlessHttp::endpoint('GET', '/hello', HelloEndpointHandler::class),
    '/api' => [
        '/v1' => [
            FlawlessHttp::endpoint('GET', '/one', OneHandler::class),
            FlawlessHttp::endpoint('GET', '/two', TwoHandler::class),
        ]
    ]
];
