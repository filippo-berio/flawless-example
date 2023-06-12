<?php

namespace App\Endpoint\App;

use App\Entity\App;
use Doctrine\ORM\EntityManagerInterface;
use Flawless\Http\Endpoint\EndpointHandlerInterface;
use Flawless\Http\Request\Request;
use Flawless\Http\Response\JsonResponse;
use Flawless\Http\Response\ResponseInterface;

class CreateAppEndpointHandler implements EndpointHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function handle(Request $request): ResponseInterface
    {
        $body = $request->getJsonBody();
        $app = new App($body['title']);
        $this->entityManager->persist($app);
        $this->entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'id' => $app->getId()
        ]);
    }
}
