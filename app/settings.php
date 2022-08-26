<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'debug' => $_ENV['DEBUG_MODE'] === 'true' ? true : false,
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => $_ENV['LOG_ERROR'] === 'true' ? true : false,
                'logErrorDetails'     => $_ENV['LOG_ERROR'] === 'true' ? true : false,
                'logger' => [
                    'name' => isset($_ENV['APP_NAME']) && !empty($_ENV['APP_NAME']) ? $_ENV['APP_NAME'] : 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app' . date('-Ymd') . '.log',
                    'level' => Logger::DEBUG,
                ],
            ]);
        }
    ]);
};
