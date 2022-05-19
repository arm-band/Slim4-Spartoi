<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Domain\Brand\BrandRepository;
use App\Infrastructure\Persistence\Brand\DBBrandRepository;
use App\Domain\BrandUser\BrandUserRepository;
use App\Infrastructure\Persistence\BrandUser\CombinedBrandUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
    ]);
    // Here we map our BrandRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        BrandRepository::class => \DI\autowire(DBBrandRepository::class),
    ]);
    // Here we map our BrandUserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        BrandUserRepository::class => \DI\autowire(CombinedBrandUserRepository::class),
    ]);
};
