<?php

namespace Flawless\Kernel\Plugin;


use Flawless\Container\ContainerInterface;

interface PluginInterface
{
    public function bootstrap(ContainerInterface $container);
}
