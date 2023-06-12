<?php

namespace Flawless\Http;

use Flawless\Container\Container;
use Flawless\Http\Application\HttpApplication;
use Flawless\Http\Endpoint\Endpoint;
use Flawless\Http\Request\Request;
use Flawless\Http\Snakee\Middleware\BaseRequestMiddleware;
use Flawless\Kernel\ApplicationInterface;
use Flawless\Kernel\FlawlessFacade;
use Flawless\Snakee\Snakee;
use Flawless\Snakee\SnakeeConfiguratorInterface;

class FlawlessHttp extends FlawlessFacade
{
    protected Request $request;

    /** @var HttpApplication */
    protected ApplicationInterface $application;

    public function __construct(
        ApplicationInterface $application
    ) {
        parent::__construct($application);
    }

    public static function boot(): self
    {
        $container = new Container();
        $application = $container->get(HttpApplication::class);

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
    ): Endpoint {
        return new Endpoint($method, $uri, $handlerClass);
    }

    public function snakee(array $requestMiddlewares = []): SnakeeConfiguratorInterface
    {
        if (!$this->snakee) {
            $this->snakee = $this->container->get(Snakee::class);
            $this->container->register(Snakee::class, $this->snakee);
        }

        foreach ($requestMiddlewares as $middlewareClass) {
            /** @var BaseRequestMiddleware $middleware */
            $middleware = $this->container->get($middlewareClass);
            $middleware->setRequest($this->request);
            $this->snakee->addContextMiddleware($middleware);
        }

        return $this->snakee;
    }

    public function registerEndpointsFrom(string $endpointsFile): self
    {
        $endpointMap = require($endpointsFile);
        $this->registerPrefixEndpoint('', $endpointMap);
        return $this;
    }

    public function execute(): self
    {
        $this->application->execute($this->request);
        return $this;
    }

    public function enableGlobalMiddleware($middlewareClass): self
    {
        $this->application->enableGlobalMiddleware($middlewareClass);
        return $this;
    }

    public function bind(string $id, string $actualId): self
    {
        $this->container->bind($id, $actualId);
        return $this;
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
