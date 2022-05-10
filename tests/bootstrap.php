<?php

// app root path
$app_root_path = __DIR__ . '/../';

require $app_root_path . 'vendor/autoload.php';

use \Dotenv\Dotenv;

// enviroment basename
$dot_env_base = $app_root_path . '.env';
if (is_readable($dot_env_base)) {
    $dotenv = Dotenv::createImmutable($app_root_path);
    $dotenv->load();
}

if(!isset($_ENV['SERVER_ENV']) || empty($_ENV['SERVER_ENV'])) {
    // error read enviroment switch var
    throw new \Exception('Enviroment isn\'t settings.');
}

// extension: development or production
$dot_env_server = $_ENV['SERVER_ENV'] === 'prod' ? '.production' : '.development';

if (is_readable($app_root_path . $dot_env_server . '.env')) {
    // reading development or production enviroment
    $dotenv = Dotenv::createImmutable($app_root_path, $dot_env_server . '.env');
    $dotenv->load();
}
