<?php
use Slim\App;

return function (App $app) {
    (require __DIR__ . '/Authenticate.php')($app);
    (require __DIR__ . '/admin/index.php')($app);
};
