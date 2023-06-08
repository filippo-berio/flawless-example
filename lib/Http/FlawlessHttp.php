<?php

namespace Flawless\Http;

use Flawless\Container\Container;
use Flawless\Http\Application\HttpApplication;
use Flawless\Http\Endpoint\Endpoint;
use Flawless\Http\Request\Request;

class FlawlessHttp
{
    private Container $container;
    private Request $request;

    public function __construct(
        private HttpApplication $application
    ) {
    }

    public static function boot(): self
    {
        $container = new Container();
        $application = new HttpApplication($container);

        $request = Request::fromGlobals();
        $self = new self($application);
        $self->container = $container;
        $self->request = $request;

        return $self;
    }

    public static function endpoint(
        string $method,
        string $uri,
        string $handlerClass,
        array $middleware = [],
    ): Endpoint {
        return new Endpoint($method, $uri, $handlerClass, $middleware);
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

    public function execute()
    {
        $this->application->execute($this->request);
    }

    private function registerPrefixEndpoint(string $prefix, array $endpoints)
    {
        foreach ($endpoints as $key => $endpoint) {
            if (is_array($endpoint)) {
                $this->registerPrefixEndpoint("$prefix$key", $endpoint);
            } else {
                /** @var Endpoint $endpoint */
                $this->application->registerEndpoint($endpoint->addPrefix($prefix));
            }
        }
    }
}
