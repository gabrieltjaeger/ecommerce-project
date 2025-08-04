<?php
use Slim\App;
use src\infra\http\controllers\api\AuthenticateController;
use src\infra\http\controllers\api\LogoutController;

return function (App $app) {
    $app->post('/admin/login', AuthenticateController::class);
    $app->get('/admin/logout', LogoutController::class);
};
