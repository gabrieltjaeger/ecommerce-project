<?php
use Slim\App;
use src\infra\http\controllers\views\AuthenticateViewController;

return function (App $app) {
    $app->get('/login', AuthenticateViewController::class);
};
