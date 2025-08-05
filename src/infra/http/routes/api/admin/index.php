<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use src\infra\http\controllers\api\AuthenticateController;
use src\infra\http\controllers\api\CreateUserController;
use src\infra\http\controllers\api\LogoutController;
use src\infra\http\controllers\api\UpdateUserController;
use src\infra\http\controllers\api\DeleteUserController;

use src\infra\http\middlewares\EnsureAuthenticatedMiddleware;

return function (App $app) {
    $app->post('/admin/login', AuthenticateController::class);
    $app->get('/admin/logout', LogoutController::class);
    $app->group('/admin', function (RouteCollectorProxy $group) {
        $group->post('/users/create', CreateUserController::class);
        $group->post('/users/{id}', UpdateUserController::class);
        $group->get('/users/{id}/delete', DeleteUserController::class);
    })->add(new EnsureAuthenticatedMiddleware());
};
