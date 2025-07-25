<?php

require_once __DIR__ . '/vendor/autoload.php';
use src\database\sql;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {

  $sql = new Sql();

  $results = $sql->select("SELECT * FROM tb_users");

  $response->getBody()->write(json_encode($results));
  return $response;
});

$app->run();

?>