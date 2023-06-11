<?php

namespace Flawless\Snakee;

use Flawless\Snakee\Context\ContextMiddlewareInterface;

interface SnakeeConfiguratorInterface
{
    /**
     * @param string|ContextMiddlewareInterface $middleware
     * @return $this
     */
    public function addContextMiddleware($middleware): self;
}
