<?php
use src\core\use_cases\AuthenticateUseCase;
use src\core\use_cases\ListUsersUseCase;
use src\core\use_cases\FetchUserUseCase;
use src\core\use_cases\CreateUserUseCase;
use src\core\use_cases\UpdateUserUseCase;
use src\core\use_cases\DeleteUserUseCase;


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
  },
  'updateUserUseCase' => function ($c) {
    return new UpdateUserUseCase(
      $c->get('usersRepository'),
      $c->get('personsRepository'),
      $c->get('encrypterService')
    );
  },
  'deleteUserUseCase' => function ($c) {
    return new DeleteUserUseCase(
      $c->get('usersRepository'),
    );
  }
];
