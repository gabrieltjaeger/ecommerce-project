<?php
use DI\Container;

$container = new Container();

foreach ([
    'repositories',
    'services',
    'usecases',
] as $provider) {
    $definitions = require __DIR__ . "/$provider.php";
    foreach ($definitions as $key => $value) {
        $container->set($key, $value);
    }
}

return $container;
