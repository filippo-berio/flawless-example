<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[Entity]
class Graph
{
    #[Id]
    #[OneToOne(inversedBy: 'graph')]
    #[JoinColumn(name: 'id', referencedColumnName: 'id')]
    private Endpoint $endpoint;

    public function __construct(
        Endpoint $endpoint,
    ) {
        $this->endpoint = $endpoint;
    }
}
