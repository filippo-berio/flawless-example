<?php

namespace Flawless\Http\Application;

use Flawless\Http\Endpoint\Endpoint;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Middleware\MiddlewareInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;
use Psr\Container\ContainerInterface;
use Throwable;

class HttpApplication
{
    /** @var Endpoint[] */
    protected array $endpoints = [];

    private array $globalMiddlewareClasses = [];

    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

    public function execute(Request $request)
    {
        $response = $this->createResponse($request);
        header("Content-Type: {$response->getContentType()}");
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }

    public function registerEndpoint(Endpoint $endpoint)
    {
        $this->endpoints[] = $endpoint;
    }

    private function createResponse(Request $request): ResponseInterface
    {
        $endpoint = $this->getEndpoint($request);
        if (!$endpoint) {
            return new Response('Endpoint not found', 404);
        }

        $request = $this->handleMiddleware($request);
        $handler = $this->container->get($endpoint->handlerClass);
        return $handler->handle($request);
    }

    private function handleMiddleware(Request $request): Request
    {
        $endpoint = $this->getEndpoint($request);
        $middlewares = [
            ...$this->globalMiddlewareClasses,
            ...$endpoint->middlewares,
        ];
        foreach ($middlewares as $middlewareClass) {
            /** @var MiddlewareInterface $middleware */
            $middleware = $this->container->get($middlewareClass);
            $request = $middleware->handle($request);
        }

        return $request;
    }

    public function enableGlobalMiddleware(string $middlewareClass)
    {
        $this->globalMiddlewareClasses[] = $middlewareClass;
    }

    private function requestMatchesEndpoint(Request $request, Endpoint $endpoint): bool
    {
        return $endpoint->uri === $request->getUri() &&
            $endpoint->method === $request->getMethod();
    }

    private function getEndpoint(Request $request): ?Endpoint
    {
        foreach ($this->endpoints as $endpoint) {
            if ($this->requestMatchesEndpoint($request, $endpoint)) {
                return $endpoint;
            }
        }
        return null;
    }
}
