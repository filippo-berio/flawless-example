<?php

namespace Flawless\Http;

use Flawless\Container\Container;
use Flawless\Http\Application\HttpApplication;
use Flawless\Http\Endpoint\EndpointHandlerFactory;
use Flawless\Http\Request\Request;

class FlawlessHttp
{

    public function __construct(
        private HttpApplication $application
    ) {
    }

    public static function boot(): self
    {
        $container = new Container();
        $request = Request::fromGlobals();
        $endpointFactory = new EndpointHandlerFactory($container);
        $application = new HttpApplication($request, $endpointFactory);
        return new self($application);
    }

    public function app()
    {
        return $this->application;
    }
}
