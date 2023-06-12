<?php

namespace App\Endpoint\Test;

use App\Snakee\Node\Test\NodeA;
use App\Snakee\Node\Test\NodeB;
use App\Snakee\Node\Test\NodeC;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;
use Flawless\Http\Snakee\Endpoint\BaseSnakeeEndpointHandler;
use Flawless\Snakee\Context\ContextInterface;

class GraphEndpointHandler extends BaseSnakeeEndpointHandler
{
    protected function buildResponse(ContextInterface $context): ResponseInterface
    {
        return new Response($context->get('response'));
    }

    protected function getGraph(): array
    {
        return [
            NodeA::class => [
                0 => NodeB::class,
                1 => NodeC::class,
            ]
        ];
    }
}
