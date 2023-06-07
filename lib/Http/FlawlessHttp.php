<?php

namespace Flawless\Http;

use Flawless\Container\Container;
use Flawless\Http\Application\HttpApplication;
use Flawless\Http\Endpoint\Endpoint;
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

    public static function endpoint(string $method, string $uri, string $handlerClass): Endpoint
    {
        return new Endpoint($method, $uri, $handlerClass);
    }

    public function registerConfigFrom(string $configFile)
    {
        $params = require($configFile);
        foreach ($params as $key => $value) {
            $this->container->register($key, $value);
        }
    }

    public function registerEndpointsFrom(string $endpointsFile)
    {
        $endpointMap = require($endpointsFile);
        $this->registerPrefixEndpoint('', $endpointMap);
    }

    public function app()
    {
        return $this->application;
    }

    private function registerPrefixEndpoint(string $prefix, array $endpoints)
    {
        foreach ($endpoints as $key => $endpoint) {
            if (is_array($endpoint)) {
                $this->registerPrefixEndpoint("$prefix$key", $endpoint);
            } else {
                $this->registerEndpoint($endpoint->addPrefix($prefix));
            }
        }
    }

    private function registerEndpoint(Endpoint $endpoint)
    {
        $this->app()->registerEndpoint($endpoint);
    }
}
