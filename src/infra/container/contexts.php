<?php

use src\infra\contexts\AuthContext;

return [
  "authContext" => function ($container) {
    return new AuthContext(
      $container->get('sessionService'),
      $container->get('usersRepository')
    );
  },
];
