<?php

namespace Flawless\Http\Application;

use Flawless\Http\Endpoint\Endpoint;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Middleware\MiddlewareInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;
use Flawless\Kernel\Application;

class HttpApplication extends Application
{
    /** @var Endpoint[] */
    protected array $endpoints = [];

    private array $globalMiddlewareClasses = [];

    public function execute(Request $request)
    {
        $response = $this->createResponse($request);
        $this->sendResponse($response);
    }

    public function registerEndpoint(Endpoint $endpoint)
    {
        $this->endpoints[] = $endpoint;
    }

    public function enableGlobalMiddleware(string $middlewareClass)
    {
        $this->globalMiddlewareClasses[] = $middlewareClass;
    }

    private function createResponse(Request $request): ResponseInterface
    {
        $endpoint = $this->getEndpoint($request);
        if (!$endpoint) {
            return new Response('Endpoint not found', 404);
        }

        $request = $this->handleMiddleware($request);
        /** @var EndpointHandlerInterface $handler */
        $handler = $this->container->get($endpoint->handlerClass);
        return $handler->handle($request);
    }

    private function sendResponse(ResponseInterface $response)
    {
        header("Content-Type: {$response->getContentType()}");
        http_response_code($response->getStatusCode());
        echo $response->getBody();
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
