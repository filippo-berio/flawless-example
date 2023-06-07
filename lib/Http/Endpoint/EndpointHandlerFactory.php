<?php

namespace Flawless\Http\Endpoint;

use Flawless\Http\Request\Request;
use Psr\Container\ContainerInterface;

class EndpointHandlerFactory
{
    protected array $endpointHandlers = [];

    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    public function createHandlerFromRequest(Request $request): ?EndpointHandlerInterface
    {
        foreach ($this->endpointHandlers as $class => [$method, $uri]) {
            if (
                $request->getMethod() === $method &&
                $this->uriMatchesRequest($uri, $request)
            ) {
                return $this->container->get($class);
            }
        }
        return null;
    }

    public function registerEndpoint(string $method, string $uri, string $handlerClass)
    {
        $this->endpointHandlers[$handlerClass] = [
            $method,
            $uri,
        ];
    }

    private function uriMatchesRequest(string $uri, Request $request): bool
    {
        return $uri === $request->getUri();
    }
}
