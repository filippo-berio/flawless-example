<?php

namespace App\Endpoint\Endpoint;

use App\Entity\Endpoint;
use App\Snakee\Node\Test\NodeA;
use Doctrine\ORM\EntityManagerInterface;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\JsonResponse;
use Flawless\Http\Response\ResponseInterface;
use Flawless\Snakee\Snakee;

class RunEndpointHandler implements EndpointHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Snakee $snakee,
    ) {
    }

    public function handle(Request $request): ResponseInterface
    {
        $path = $request->getQuery()->get('uri');
        $method = $request->getMethod();

        /** @var Endpoint $endpoint */
        $endpoint = $this->entityManager->getRepository(Endpoint::class)
            ->findOneBy([
                'method' => $method,
                'path' => $path
            ]);

        $graph = $endpoint->getGraph();

        $context = $this->snakee->run($graph);
        return new JsonResponse($context->all());
    }
}
