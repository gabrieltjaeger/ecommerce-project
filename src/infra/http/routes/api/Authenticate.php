<?php
use Slim\App;
use src\infra\http\controllers\api\AuthenticateController;

return function (App $app) {
    $app->post('/login', AuthenticateController::class);
};
