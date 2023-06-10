<?php

namespace App\Snakee\Node;

use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Node\NodeInterface;

class NodeA implements NodeInterface
{

    public function getOutputs(): array
    {
        return [0, 1];
    }

    public function handle(ContextInterface $context)
    {
        $number = $context->safeGet('num');
        if ($number) {
            $context->set('num', $number);
            return 0;
        }
        return 1;
    }
}
