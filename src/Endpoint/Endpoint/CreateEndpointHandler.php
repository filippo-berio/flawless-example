<?php

namespace App\Endpoint\Endpoint;

use App\Entity\App;
use App\Entity\Endpoint;
use Doctrine\ORM\EntityManagerInterface;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\JsonResponse;
use Flawless\Http\Response\ResponseInterface;

class CreateEndpointHandler implements EndpointHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(Request $request): ResponseInterface
    {
        $body = $request->getJsonBody();
        $app = $this->entityManager->getRepository(App::class)->find($body['appId']);
        $endpoint = new Endpoint(
            $app,
            $body['title'],
            $body['path'],
            $body['method'],
            $body['graph'],
        );
        $this->entityManager->persist($endpoint);
        $this->entityManager->flush($endpoint);
        return new JsonResponse([
            'id' => $endpoint->getId(),
        ]);
    }
}
