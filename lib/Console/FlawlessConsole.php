<?php

namespace Flawless\Console;

use Flawless\Container\Container;
use Flawless\Kernel\Application;
use Flawless\Kernel\ApplicationInterface;
use Flawless\Kernel\FlawlessFacade;
use Psr\Container\ContainerInterface as PsrContainerInterface;

class FlawlessConsole extends FlawlessFacade
{
    /** @var Application */
    protected ApplicationInterface $application;

    public function __construct(
        ApplicationInterface $application
    ) {
        parent::__construct($application);
    }

    public static function boot(): self
    {
        $container = new Container();
        $application = $container->get(Application::class);

        $self = new self($application);
        $self->container = $container;

        return $self;
    }

    public function getContainer(): PsrContainerInterface
    {
        return $this->container;
    }
}
