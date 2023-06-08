<?php

namespace Flawless\Http\Endpoint;

use Flawless\Http\Request\Request;
use Psr\Container\ContainerInterface;

class EndpointHandlerFactory
{
    /** @var Endpoint[] */
    protected array $endpoints = [];

    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    public function createHandlerFromRequest(Request $request): ?EndpointHandlerInterface
    {
        foreach ($this->endpoints as $endpoint) {
            if ($this->requestMatchesEndpoint($request, $endpoint)) {
                return $this->container->get($endpoint->handlerClass);
            }
        }
        return null;
    }

    public function registerEndpoint(Endpoint $endpoint)
    {
        $this->endpoints[] = $endpoint;
    }

    private function requestMatchesEndpoint(Request $request, Endpoint $endpoint): bool
    {
        return $endpoint->uri === $request->getUri();
    }
}
