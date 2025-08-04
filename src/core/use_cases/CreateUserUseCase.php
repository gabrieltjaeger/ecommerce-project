<?php

namespace src\core\use_cases;

use src\core\entities\User;
use src\core\entities\Person;

use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\PersonsRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;
use src\core\repositories\requests\PersonSearchRequest;

use src\core\services\EncrypterServiceInterface;


class CreateUserUseCase
{
  private UsersRepositoryInterface $usersRepository;
  private PersonsRepositoryInterface $personsRepository;
  private EncrypterServiceInterface $encrypterService;

  public function __construct(UsersRepositoryInterface $usersRepository, PersonsRepositoryInterface $personsRepository, EncrypterServiceInterface $encrypterService)
  {
    $this->usersRepository = $usersRepository;
    $this->personsRepository = $personsRepository;
    $this->encrypterService = $encrypterService;
  }

  public function execute(string $name, string $login, string $phone, string $email, string $password, bool $isAdmin): ?User
  {
    var_dump($name, $login, $phone, $email, $password, $isAdmin);
    $userWithSameLogin = $this->usersRepository->find(new UserSearchRequest(login: $login));
    if ($userWithSameLogin) {
      throw new \Exception('User with this login already exists');
    }

    $personWithSameEmail = $this->personsRepository->find(new PersonSearchRequest(email: $email));
    var_dump($personWithSameEmail);
    if ($personWithSameEmail) {
      throw new \Exception('User with this email already exists');
    }

    $personWithSamePhone = $this->personsRepository->find(new PersonSearchRequest(phone: $phone));
    if ($personWithSamePhone) {
      throw new \Exception('User with this phone already exists');
    }

    $user = new User(
      id: null,
      person: new Person(
        name: $name,
        email: $email,
        phone: $phone
      ),
      login: $login,
      password_hash: $this->encrypterService->encrypt($password),
      is_admin: $isAdmin
    );

    var_dump($user);

    $this->usersRepository->create($user);

    return $user;
  }
}