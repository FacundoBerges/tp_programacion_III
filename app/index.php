<?php

// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './database/DataAccessObject.php';


$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);


// $app->get(
//   '/',
//   function (Request $request, Response $response, array $args) {
//     $response->getBody()->write("Funciona!");

//     return $response;
//   }
// );

// $app->get(
//   '/hello/{name}',
//   function (Request $request, Response $response, array $args) {
//     $name = $request->getAttributes()['name'];
//     $response->getBody()->write("Bienvenido, " . $name . "!");

//     return $response;
//   }
// );

$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('/bartenders',);
});


$app->run();
