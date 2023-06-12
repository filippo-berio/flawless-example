<?php

namespace Flawless\Kernel\Plugin\Base;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Flawless\Container\ContainerInterface;
use Flawless\Kernel\Plugin\PluginInterface;

class DoctrinePlugin implements PluginInterface
{

    public function bootstrap(ContainerInterface $container)
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [$container->get('rootDir') . '/src'],
        );

        $connection = DriverManager::getConnection([
            'driver'   => $container->get('dbDriver'),
            'user'     => $container->get('dbUser'),
            'password' => $container->get('dbPass'),
            'dbname'   => $container->get('dbName'),
            'host'     => $container->get('dbHost'),
        ], $config);

        $entityManager = new EntityManager($connection, $config);

        $container->register(EntityManagerInterface::class, $entityManager);
    }
}
