<?php
use src\core\use_cases\AuthenticateUseCase;

return [
  'authenticateUseCase' => function ($c) {
    return new AuthenticateUseCase($c->get('usersRepository'));
  },
];
