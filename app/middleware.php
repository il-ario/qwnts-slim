<?php
declare(strict_types=1);

use Slim\App;
use App\Application\Middleware\SessionMiddleware;
use Tuupola\Middleware\JwtAuthentication;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->addBodyParsingMiddleware();
    $app->add(JwtAuthentication::class);
};
