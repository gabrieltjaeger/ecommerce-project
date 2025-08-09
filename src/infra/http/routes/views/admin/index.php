<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use src\infra\http\middlewares\EnsureAuthenticatedMiddleware;

use src\infra\http\controllers\views\admin\ListUsersViewController;
use src\infra\http\controllers\views\admin\ListCategoriesViewController;

use src\infra\http\controllers\views\admin\AuthenticateViewController;
use src\infra\http\controllers\views\admin\CreateUserViewController;
use src\infra\http\controllers\views\admin\IndexViewController;
use src\infra\http\controllers\views\admin\UpdateUserViewController;
use src\infra\http\controllers\views\admin\CreateCategoryViewController;
use src\infra\http\controllers\views\admin\UpdateCategoryViewController;

return function (App $app) {
  $app->get('/admin/login', AuthenticateViewController::class);

  $app->group('/admin', function (RouteCollectorProxy $group) {
    $group->get('', IndexViewController::class);

    $group->get('/users', ListUsersViewController::class);

    $group->get('/users/create', CreateUserViewController::class);

    $group->get('/users/{id}', UpdateUserViewController::class);

    $group->get('/categories', ListCategoriesViewController::class);

    $group->get('/categories/create', CreateCategoryViewController::class);

    $group->get('/categories/{id}', UpdateCategoryViewController::class);
  })->add(new EnsureAuthenticatedMiddleware());
};
