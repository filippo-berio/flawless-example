<?php

namespace Flawless\Kernel;

use Flawless\Container\ContainerInterface;
use Flawless\Snakee\Snakee;

class FlawlessFacade
{
    protected ContainerInterface $container;
    protected ?Snakee $snakee = null;

    public function __construct(
        protected ApplicationInterface $application
    ) {
    }

    public function enablePlugin(string $pluginClass): self
    {
        $this->application->enablePlugin($pluginClass);
        return $this;
    }

    public function registerConfigFrom(string $configFile): self
    {
        $params = require($configFile);
        foreach ($params as $key => $value) {
            $this->container->register($key, $value);
        }
        return $this;
    }
}
