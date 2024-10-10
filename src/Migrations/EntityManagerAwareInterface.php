<?php

namespace App\Migrations;

use Doctrine\ORM\EntityManagerInterface;

interface EntityManagerAwareInterface
{
    public function setEntityManager(EntityManagerInterface $entityManager): void;
}
