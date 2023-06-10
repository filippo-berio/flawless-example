<?php

namespace Flawless\Snakee\Node;

use Flawless\Snakee\Context\ContextInterface;

interface NodeInterface
{
    public const NONE = 'snakee_node_none';

    public function getOutputs(): array;

    public function handle(ContextInterface $context);
}
