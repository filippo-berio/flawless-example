<?php

namespace Flawless\Http\Snakee\Middleware;

use Flawless\Http\Request\Request;
use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Context\ContextMiddlewareInterface;

abstract class BaseRequestMiddleware implements ContextMiddlewareInterface
{
    protected Request $request;

    public function handle(ContextInterface $context): ContextInterface
    {
        foreach ($this->getRequestData($this->request) as $key => $data) {
            $context->set($key, $data);
        }
        return $context;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    protected abstract function getRequestData(Request $request): array;
}
