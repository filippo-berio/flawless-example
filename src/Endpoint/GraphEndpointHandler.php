<?php

namespace App\Endpoint;

use App\Snakee\Node\NodeA;
use App\Snakee\Node\NodeB;
use App\Snakee\Node\NodeC;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\Response;
use Flawless\Http\Response\ResponseInterface;
use Flawless\Snakee\Context\ExecutionContext;
use Flawless\Snakee\Manager;

class GraphEndpointHandler implements EndpointHandlerInterface
{
    public function __construct(
        private Manager $manager
    ) {
    }

    public function handle(Request $request): ResponseInterface
    {
        $context = new ExecutionContext([
            'num' => $request->getQuery()->get('num'),
        ]);
        $this->manager->setContext($context);
        $context = $this->manager->run([
            NodeA::class => [
                0 => NodeB::class,
                1 => NodeC::class,
            ]
        ]);
        $text = $context->safeGet('response');
        return new Response($text);
    }
}
