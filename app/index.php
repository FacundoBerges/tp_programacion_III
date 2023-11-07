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
require_once './controller/UsuarioController.php';
require_once './controller/ProductoController.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__);
$dotenv->safeLoad();


$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);


// USUARIOS
$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('[/]', \UsuarioController::class . ":getAll");
  $group->get('/{id}', \UsuarioController::class . ":getOne");

  $group->post('[/]', \UsuarioController::class . ":save");
});

// PRODUCTOS
$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ":getAll");
  $group->get('/{id}', \ProductoController::class . ":getOne");

  $group->post('[/]', \ProductoController::class . ":save");
});


$app->run();
