<?php
use src\core\use_cases\AuthenticateUseCase;
use src\core\use_cases\ListUsersUseCase;
use src\core\use_cases\FetchUserUseCase;
use src\core\use_cases\CreateUserUseCase;


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
  },
  'fetchUserUseCase' => function ($c) {
    return new FetchUserUseCase(
      $c->get('usersRepository')
    );
  },
  'createUserUseCase' => function ($c) {
    return new CreateUserUseCase(
      $c->get('usersRepository'),
      $c->get('personsRepository'),
      $c->get('encrypterService')
    );
  }
];
