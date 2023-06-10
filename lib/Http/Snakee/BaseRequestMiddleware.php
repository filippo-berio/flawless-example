<?php

namespace Flawless\Http\Snakee;

use Flawless\Http\Request\Request;
use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Context\ContextMiddlewareInterface;

abstract class BaseRequestMiddleware implements ContextMiddlewareInterface
{
    public function __construct()
    {
    }

    public function handle(ContextInterface $context): ContextInterface
    {
        foreach ($this->getRequestData() as $key => $data) {
            $context->set($key, $data);
        }
        return $context;
    }

    protected abstract function getRequestData(Request $request): array;
}
