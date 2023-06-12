<?php

namespace Flawless\Kernel;

use Flawless\Container\ContainerInterface;
use Flawless\Kernel\Plugin\PluginInterface;

class Application implements ApplicationInterface
{
    public function __construct(
        protected ContainerInterface $container,
    ) {
    }

    public function enablePlugin(string $pluginClass)
    {
        /** @var PluginInterface $plugin */
        $plugin = $this->container->get($pluginClass);
        $plugin->bootstrap($this->container);
    }
}
