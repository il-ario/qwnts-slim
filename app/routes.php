<?php
declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    // $app->options('/{routes:.*}', function (Request $request, Response $response) {
    //     // CORS Pre-Flight OPTIONS Request Handler
    //     return $response;
    // });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    /**
     * Users
     */
    $app->group('/users', function (Group $group) {
        $group->get('', \App\Application\Actions\User\ListUsersAction::class);
        $group->post('', \App\Application\Actions\User\StoreUserAction::class);
        $group->get('/{email}', \App\Application\Actions\User\ViewUserAction::class);
        $group->put('/{email}', \App\Application\Actions\User\UpdateUserAction::class);
        $group->delete('/{email}', \App\Application\Actions\User\DeleteUserAction::class);
    });

    /**
     * Posts
     */
    $app->group('/posts', function (Group $group) {
        $group->get('', \App\Application\Actions\Post\ListPostsAction::class);
        $group->post('', \App\Application\Actions\Post\StorePostAction::class);
        $group->get('/{id}', \App\Application\Actions\Post\ViewPostAction::class);
        $group->put('/{id}', \App\Application\Actions\Post\UpdatePostAction::class);
    });
};
