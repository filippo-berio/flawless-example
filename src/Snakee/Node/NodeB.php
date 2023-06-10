<?php

namespace App\Snakee\Node;

use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Node\NodeInterface;

class NodeB implements NodeInterface
{

    public function getOutputs(): array
    {
        return [];
    }

    public function handle(ContextInterface $context)
    {
        $context->set('response', 'The number is ' . $context->safeGet('num'));
    }
}
