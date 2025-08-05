<?php

namespace src\core\use_cases;

use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\PersonsRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;

use src\core\services\EncrypterServiceInterface;


class UpdateUserUseCase
{
  private UsersRepositoryInterface $usersRepository;
  private PersonsRepositoryInterface $personsRepository;
  private EncrypterServiceInterface $encrypterService;

  public function __construct(
    UsersRepositoryInterface $usersRepository,
    PersonsRepositoryInterface $personsRepository,
    EncrypterServiceInterface $encrypterService
  ) {
    $this->usersRepository = $usersRepository;
    $this->personsRepository = $personsRepository;
    $this->encrypterService = $encrypterService;
  }

  public function execute(int $user_id, string $name, string $email, string $phone, string $login, string $password, bool $is_admin): void
  {
    $user = $this->usersRepository->find(new UserSearchRequest(id: $user_id));
    if (!$user) {
      throw new \InvalidArgumentException('User not found');
    }

    $person = $user->getPerson();
    if (!$person) {
      throw new \InvalidArgumentException('User must have a Person');
    }

      $finalName = ($name !== null && $name !== '') ? $name : $person->getName();
      $finalEmail = ($email !== null && $email !== '') ? $email : $person->getEmail();
      $finalPhone = ($phone !== null && $phone !== '') ? $phone : ($person->getPhone() ?? '');
      $finalLogin = ($login !== null && $login !== '') ? $login : $user->getLogin();
      $finalPasswordHash = ($password !== null && $password !== '')
        ? $this->encrypterService->encrypt($password)
        : $user->getPasswordHash();
      $finalIsAdmin = $is_admin;

      $person->setName($finalName);
      $person->setEmail($finalEmail);
      $person->setPhone($finalPhone);
      $user->setLogin($finalLogin);
      $user->setPasswordHash($finalPasswordHash);
      $user->setIsAdmin($finalIsAdmin);

      $this->usersRepository->update($user);
  }
}

?>