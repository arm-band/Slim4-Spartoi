<?php

// app root path
const APPROOT_PATH = __DIR__ . '/../';

require APPROOT_PATH . 'vendor/autoload.php';

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
