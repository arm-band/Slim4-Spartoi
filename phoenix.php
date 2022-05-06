<?php

use \Dotenv\Dotenv;

// enviroment path
$dot_env_path = __DIR__ . '/';
// enviroment basename
$dot_env_base = $dot_env_path . '.env';
if (is_readable($dot_env_base)) {
    $dotenv = Dotenv::createImmutable($dot_env_path);
    $dotenv->load();
}

if(!isset($_ENV['SERVER_ENV']) || empty($_ENV['SERVER_ENV'])) {
    // error read enviroment switch var
    throw new \Exception('Enviroment isn\'t settings.');
}

// extension: development or production
$dot_env_server = $_ENV['SERVER_ENV'] === 'prod' ? '.production' : '.development';

if (is_readable($dot_env_path . $dot_env_server . '.env')) {
    // reading development or production enviroment
    $dotenv = Dotenv::createImmutable($dot_env_path, $dot_env_server . '.env');
    $dotenv->load();
}

return [
    'migration_dirs' => [
        'first'  => __DIR__ . '/_migrations',
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
            'host'     => $_ENV['MYSQL_HOST'],
            'port'     => (int)$_ENV['MYSQL_PORT'], // optional
            'username' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD'],
            'db_name'  => $_ENV['MYSQL_DBNAME'],
            'charset'  => 'utf8mb4',
        ],
    ],
    'default_environment' => 'local',
    'log_table_name'      => 'phoenix_log',
];
