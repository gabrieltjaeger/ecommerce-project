<?php

namespace src\core\use_cases;

use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;

use src\core\services\EncrypterServiceInterface;


class DeleteUserUseCase
{
  private UsersRepositoryInterface $usersRepository;

  public function __construct(
    UsersRepositoryInterface $usersRepository
  ) {
    $this->usersRepository = $usersRepository;
  }

  public function execute(string $userId): void
  {
    $user = $this->usersRepository->find(new UserSearchRequest(id: $userId));
    if (!$user) {
      throw new \Exception('User not found');
    }

    $this->usersRepository->delete($user);
  }
}