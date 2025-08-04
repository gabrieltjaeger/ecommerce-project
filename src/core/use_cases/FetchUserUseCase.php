<?php

namespace src\core\use_cases;

use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;
use src\core\entities\User;

class FetchUserUseCase
{
  private UsersRepositoryInterface $usersRepository;

  public function __construct(UsersRepositoryInterface $usersRepository)
  {
    $this->usersRepository = $usersRepository;
  }

  public function execute(int $id): ?User
  {
    $user = $this->usersRepository->find(request: new UserSearchRequest(id: $id));

    return $user;
  }
}