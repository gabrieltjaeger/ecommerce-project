<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use src\presentation\AdminPage;
use src\infra\http\middlewares\EnsureAuthenticatedMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\infra\http\controllers\views\admin\AuthenticateViewController;
use src\infra\http\controllers\views\ListUsersViewController;

return function (App $app) {
  $app->get('/admin/login', AuthenticateViewController::class);

  $app->group('/admin', function (RouteCollectorProxy $group) {
    $group->get('', function (Request $request, Response $response) {
      $page = new AdminPage([], 'index.html.twig');
      $response->getBody()->write($page->fetch());
      return $response->withHeader('Content-Type', 'text/html');
    });

    $group->get('/users', ListUsersViewController::class);

  })->add(new EnsureAuthenticatedMiddleware());
};
