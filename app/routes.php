<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\Brand\ListBrandsAction;
use App\Application\Actions\Brand\ViewBrandAction;
use App\Application\Actions\BrandUser\ListBrandUsersAction;
use App\Application\Actions\BrandUser\ViewBrandUserAction;
use App\Application\Settings\SettingsInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $c = $app->getContainer();

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) use ($c) {
        $response->getBody()->write("Hello {$_ENV['APP_NAME']}!");
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
    $app->group('/brands', function (Group $group) {
        $group->get('', ListBrandsAction::class);
        $group->get('/{id}', ViewBrandAction::class);
    });
    $app->group('/brandusers', function (Group $group) {
        $group->get('', ListBrandUsersAction::class);
        $group->get('/{id}', ViewBrandUserAction::class);
    });
};
