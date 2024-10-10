<?php

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;

return [
    FrameworkBundle::class          => ['all' => true],
    MakerBundle::class              => ['dev' => true],
    DoctrineBundle::class           => ['all' => true],
    DoctrineMigrationsBundle::class => ['all' => true],
    TwigBundle::class               => ['all' => true],
    MonologBundle::class            => ['all' => true],
    DoctrineFixturesBundle::class   => ['dev' => true, 'test' => true],
];
