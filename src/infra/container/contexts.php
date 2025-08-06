<?php

use src\infra\contexts\AuthContext;
use src\infra\contexts\AdminPagesContext;

return [
  "authContext" => function ($container) {
    return new AuthContext(
      $container->get('sessionService'),
      $container->get('usersRepository')
    );
  },
  "adminPagesContext" => function ($container) {
    return new AdminPagesContext();
  }
];
