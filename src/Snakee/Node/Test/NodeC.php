<?php

namespace App\Snakee\Node\Test;

use App\Service\Test\HelloService;
use Flawless\Snakee\Context\ContextInterface;
use Flawless\Snakee\Node\NodeInterface;

class NodeC implements NodeInterface
{
    public function __construct(
        private HelloService $helloService
    ) {
    }

    public function getOutputs(): array
    {
        return [];
    }

    public function handle(ContextInterface $context)
    {
        $context->set('response', 'No number, ' . $this->helloService->hello());
    }
}
