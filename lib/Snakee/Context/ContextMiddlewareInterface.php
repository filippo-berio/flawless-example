<?php

namespace Flawless\Snakee\Context;

interface ContextMiddlewareInterface
{
    public function handle(ContextInterface $context): ContextInterface;
}
