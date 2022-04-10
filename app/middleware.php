<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use App\Application\Settings\SettingsInterface;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);

    $c = $app->getContainer();
    if ((bool)($c->get(SettingsInterface::class)->get('debug') ?? false)) {
        $app->add(new Zeuxisoo\Whoops\Slim\WhoopsMiddleware(
            [
                'enable' => true,
            ]
        ));
    } else {
        $errorMiddleware = $app->addErrorMiddleware(false, true, true);
        $errorHandler    = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->registerErrorRenderer('text/html', HtmlErrorRenderer::class);
    }
};
