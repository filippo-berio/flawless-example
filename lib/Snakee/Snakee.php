<?php

namespace Flawless\Snakee;

use Flawless\Container\ContainerInterface;
use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Context\ContextMiddlewareInterface;
use Flawless\Snakee\Context\ExecutionContext;
use Flawless\Snakee\Node\NodeInterface;

class Snakee implements SnakeeConfiguratorInterface
{
    private ContextInterface $context;

    /** @var ContextMiddlewareInterface[] */
    private array $middlewares = [];

    public function __construct(
        private ContainerInterface $container,
    ) {
        $this->context = new ExecutionContext();
    }

    public function withContext(ContextInterface $context): self
    {
        $this->context = $context;
        return $this;
    }

    public function addContextMiddleware($middleware): self
    {
        if (is_string($middleware)) {
            $middleware = $this->container->get($middleware);
        }
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function run(array $graph, ?string $startingNode = null): ContextInterface
    {
        foreach ($this->middlewares as $middleware) {
            $this->context = $middleware->handle($this->context);
        }

        $forks = array_keys($graph);
        $nodeClass = $startingNode ?? $forks[0];

        while (true) {
            /** @var NodeInterface $node */
            $node = $this->container->get($nodeClass);
            $output = $node->handle($this->context);

            if (!in_array($nodeClass, $forks)) {
                break;
            }
            $nodeClass = $graph[$nodeClass][$output];
        }

        return $this->context;
    }
}
