<?php

namespace App\Snakee\Node;

use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Node\NodeInterface;

class NodeC implements NodeInterface
{

    public function getOutputs(): array
    {
        return [];
    }

    public function handle(ContextInterface $context)
    {
        $context->set('response', 'No number!');
    }
}
