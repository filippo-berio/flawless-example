<?php

namespace Flawless\Snakee\Node;

use Flawless\Snakee\Context\ContextInterface;

interface NodeInterface
{
    public function getOutputs(): array;

    public function handle(ContextInterface $context);
}
