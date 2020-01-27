<?php
declare(strict_types=1);

use App\Application\Actions\Quote\ViewQuotesAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/shout/{quote_author}', ViewQuotesAction::class);

};
