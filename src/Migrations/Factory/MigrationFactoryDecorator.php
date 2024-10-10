<?php

declare(strict_types=1);

namespace App\Migrations\Factory;

use App\Migrations\EntityManagerAwareInterface;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Version\MigrationFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final readonly class MigrationFactoryDecorator implements MigrationFactory
{
    public function __construct(
        private MigrationFactory $migrationFactory,
        private ContainerInterface $container
    ) {}

    public function createVersion(string $migrationClassName): AbstractMigration
    {
        $instance = $this->migrationFactory->createVersion($migrationClassName);

        if ($instance instanceof EntityManagerAwareInterface) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            assert($em instanceof EntityManagerInterface);
            $instance->setEntityManager($em);
        }

        return $instance;
    }
}
