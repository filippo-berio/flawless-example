<?php

namespace App\Endpoint;

use App\Snakee\Node\NodeA;
use App\Snakee\Node\NodeB;
use App\Snakee\Node\NodeC;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;
use Flawless\Http\Snakee\Endpoint\BaseSnakeeEndpointHandler;
use Flawless\Snakee\Context\ContextInterface;

class GraphEndpointHandler extends BaseSnakeeEndpointHandler
{
    private Request $request;

    public function handle(Request $request): ResponseInterface
    {
        $this->request = $request;
        return parent::handle($request);
    }

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
