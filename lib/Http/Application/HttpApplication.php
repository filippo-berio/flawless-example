<?php

namespace Flawless\Http\Application;

use Flawless\Http\Endpoint\EndpointHandlerFactory;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;
use Throwable;

class HttpApplication
{
    public function __construct(
        protected Request $request,
        protected EndpointHandlerFactory $endpointHandlerFactory,
    ) {
    }

    public function registerEndpoint(string $method, string $uri, string $handlerClass)
    {
        $this->endpointHandlerFactory->registerEndpoint($method, $uri, $handlerClass);
    }

    public function execute()
    {
        $response = $this->createResponse();
        header("Content-Type: {$response->getContentType()}");
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }

    private function createResponse(): ResponseInterface
    {
        $handler = $this->endpointHandlerFactory->createHandlerFromRequest($this->request);
        if (!$handler) {
            return new Response('Endpoint not found', 404);
        }

        try {
            return $handler->handle($this->request);
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), 500);
        }
    }
}
