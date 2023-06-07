<?php

namespace Flawless\Http;

use Flawless\Container\Container;
use Flawless\Http\Application\HttpApplication;
use Flawless\Http\Endpoint\EndpointHandlerFactory;
use Flawless\Http\Request\Request;

class FlawlessHttp
{
    private Container $container;

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
        $self = new self($application);
        $self->container = $container;
        return $self;
    }

    public function registerConfigFrom(string $configFile)
    {
        $params = require($configFile);
        foreach ($params as $key => $value) {
            $this->container->register($key, $value);
        }
    }

    public function app()
    {
        return $this->application;
    }
}
