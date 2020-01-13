<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/shout/{quote_author}', function (Request $request, Response $response, $args) {
        $limit = empty($request->getAttributes()['limit']) ? 1 : $request->getAttributes()['limit'];
        $response->getBody()->write(
            "Quote Author: {$args['quote_author']}"
            . " Requested Quotes: {$limit}"
        );
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
