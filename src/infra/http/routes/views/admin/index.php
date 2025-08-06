<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use src\infra\http\middlewares\EnsureAuthenticatedMiddleware;

use src\infra\http\controllers\views\ListUsersViewController;

use src\infra\http\controllers\views\admin\AuthenticateViewController;
use src\infra\http\controllers\views\admin\CreateUserViewController;
use src\infra\http\controllers\views\admin\IndexViewController;
use src\infra\http\controllers\views\admin\UpdateUserViewController;

return function (App $app) {
  $app->get('/admin/login', AuthenticateViewController::class);

  $app->group('/admin', function (RouteCollectorProxy $group) {
    $group->get('', IndexViewController::class);

    $group->get('/users', ListUsersViewController::class);

    $group->get('/users/create', CreateUserViewController::class);

    $group->get('/users/{id}', UpdateUserViewController::class);
  })->add(new EnsureAuthenticatedMiddleware());
};
