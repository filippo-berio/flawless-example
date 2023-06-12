<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\PostLoad;

#[Entity]
#[HasLifecycleCallbacks]
class Endpoint
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private int|null $id = null;

    #[ManyToOne]
    private App $app;

    #[Column]
    private string $title;

    #[Column]
    private string $path;

    #[Column]
    private string $method;

    private array $graph;

    #[Column]
    private string $graphJson;

    public function __construct(
        App    $app,
        string $title,
        string $path,
        string $method,
        array $graph
    ) {
        $this->app = $app;
        $this->title = $title;
        $this->path = $path;
        $this->method = $method;
        $this->graphJson = json_encode($graph, 256);
    }

    #[PostLoad]
    public function setGraph()
    {
        $this->graph = json_decode($this->graphJson, true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGraph(): array
    {
        return $this->graph;
    }
}
