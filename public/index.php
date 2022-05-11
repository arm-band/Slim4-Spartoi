<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Psr\Log\LoggerInterface;

// app root path
const APPROOT_PATH = __DIR__ . '/../';

require APPROOT_PATH . 'vendor/autoload.php';

// added code
// enviroment basename
const DOTENV_BASE = APPROOT_PATH . '.env';
if (is_readable(DOTENV_BASE)) {
    $dotenv = Dotenv\Dotenv::createImmutable(APPROOT_PATH);
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
    $dotenv = Dotenv\Dotenv::createImmutable(APPROOT_PATH, $DOT_ENV_SERVER . '.env');
    $dotenv->load();
}

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(APPROOT_PATH . 'var/cache');
}

// Set up settings
$settings = require APPROOT_PATH . 'app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require APPROOT_PATH . 'app/dependencies.php';
$dependencies($containerBuilder);

// Set up DBConnection
$dbconnection = require APPROOT_PATH . 'app/dbconnection.php';
$dbconnection($containerBuilder);

// Set up repositories
$repositories = require APPROOT_PATH . 'app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
if(isset($_ENV['APP_PATH']) && !empty($_ENV['APP_PATH'])) {
    $app->setBasePath($_ENV['APP_PATH']);
}
$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require APPROOT_PATH . 'app/middleware.php';
$middleware($app);

// Register routes
$routes = require APPROOT_PATH . 'app/routes.php';
$routes($app);

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$logger = $container->get(LoggerInterface::class);
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory, $logger);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
