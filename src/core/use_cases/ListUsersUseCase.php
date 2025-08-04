<?php

namespace src\core\use_cases;

use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;
use src\core\entities\User;

class ListUsersUseCase
{
  private UsersRepositoryInterface $usersRepository;

  public function __construct(UsersRepositoryInterface $usersRepository)
  {
    $this->usersRepository = $usersRepository;
  }

  public function execute(int $page, string $name): array
  {
    $users = $this->usersRepository->list(new UserSearchRequest(page: $page, login: $name));
    return $users;
  }
}