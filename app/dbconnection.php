<?php

declare(strict_types=1);

use App\Application\DBConnection\DBConnection;
use App\Application\DBConnection\DBConnectionInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        DBConnectionInterface::class => function () {
            return new DBConnection();
        }
    ]);
};
