<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Node
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private int|null $id = null;

    #[Column]
    private string $title;

    #[Column]
    private string $class;

    #[Column]
    private array $outputs;

    public function __construct(
        string $title,
        string $class,
        array $outputs = [],
    ) {
        $this->title = $title;
        $this->class = $class;
        $this->outputs = $outputs;
    }
}
