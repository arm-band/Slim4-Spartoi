<?php

use \Dotenv\Dotenv;

// find environment file
$dot_env = __DIR__ . '/.env';
if (is_readable($dot_env)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/');
    $dotenv->load();
}

return [
    'migration_dirs' => [
        'first'  => __DIR__ . '/migrations',
    ],
    'environments' => [
        'local'      => [
            'adapter'  => 'mysql',
            'host'     => $_ENV['MYSQL_HOST'],
            'port'     => (int)$_ENV['MYSQL_PORT'], // optional
            'username' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD'],
            'db_name'  => $_ENV['MYSQL_DBNAME'],
            'charset'  => 'utf8mb4',
        ],
        'production' => [
            'adapter'  => 'mysql',
            'host'     => 'production_host',
            'port'     => 3306, // optional
            'username' => 'user',
            'password' => 'pass',
            'db_name'  => 'my_production_db',
            'charset'  => 'utf8mb4',
        ],
    ],
    'default_environment' => 'local',
    'log_table_name'      => 'phoenix_log',
];
