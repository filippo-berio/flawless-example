<?php

namespace Flawless\Http\Snakee\Endpoint;

use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\ResponseInterface;
use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Snakee;

abstract class BaseSnakeeEndpointHandler implements EndpointHandlerInterface
{
    public function __construct(
        private Snakee $manager
    ) {
    }

    public function handle(Request $request): ResponseInterface
    {
        if ($context = $this->getContext()) {
            $this->manager->withContext($context);
        }
        $context = $this->manager->run($this->getGraph());
        return $this->buildResponse($context);
    }

    protected abstract function buildResponse(ContextInterface $context): ResponseInterface;

    protected abstract function getGraph(): array;

    protected function getContext(): ?ContextInterface
    {
        return null;
    }
}
