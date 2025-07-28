<?php

require_once __DIR__ . '/vendor/autoload.php';
use src\infra\database\SQL;
use src\presentation\Page;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response) {
  $sql = new Sql();
  $users = $sql->select("SELECT * FROM tb_users");

  $page = new Page(['users' => $users], 'home.html.twig');
  $response->getBody()->write($page->fetch());
  return $response->withHeader('Content-Type', 'text/html');
});

$app->get('/about', function (Request $request, Response $response) {
  $page = new Page([], 'about.html.twig');
  $response->getBody()->write($page->fetch());
  return $response->withHeader('Content-Type', 'text/html');
});

$app->run();

?>