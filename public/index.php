
<?php

session_start();


require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$container = require __DIR__ . '/../src/infra/container/index.php';
AppFactory::setContainer($container);

use src\infra\http\middlewares\EnsureAuthenticatedMiddleware;

$app = AppFactory::create();

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$ensureAuthenticated = new EnsureAuthenticatedMiddleware();

(require __DIR__ . '/../src/infra/http/routes/api/index.php')($app);
(require __DIR__ . '/../src/infra/http/routes/views/index.php')($app);

$app->run();

?>