<?php
use src\core\use_cases\AuthenticateUseCase;
use src\core\use_cases\ListUsersUseCase;


return [
  'authenticateUseCase' => function ($c) {
    return new AuthenticateUseCase(
      $c->get('usersRepository'),
      $c->get('sessionService')
    );
  },
  'listUsersUseCase' => function ($c) {
    return new ListUsersUseCase(
      $c->get('usersRepository')
    );
  }
];
