<?php

const TIMEZONE = 'Asia/Tokyo';
const LANG = 'ja';
const ENCODE = 'UTF-8';

date_default_timezone_set(TIMEZONE);
mb_language(LANG);
mb_internal_encoding(ENCODE);

// app root path
const APPROOT_PATH = __DIR__ . '/';

use \Dotenv\Dotenv;

// enviroment basename
const DOTENV_BASE = APPROOT_PATH . '.env';
if (is_readable(DOTENV_BASE)) {
    $dotenv = Dotenv::createImmutable(APPROOT_PATH);
    $dotenv->load();
}

if(!isset($_ENV['SERVER_ENV']) || empty($_ENV['SERVER_ENV'])) {
    // error read enviroment switch var
    throw new \Exception('Enviroment isn\'t settings.');
}

// extension: development or production
$DOT_ENV_SERVER = $_ENV['SERVER_ENV'] === 'prod' ? '.production' : '.development';

if (is_readable(APPROOT_PATH . $DOT_ENV_SERVER . '.env')) {
    // reading development or production enviroment
    $dotenv = Dotenv::createImmutable(APPROOT_PATH, $DOT_ENV_SERVER . '.env');
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
