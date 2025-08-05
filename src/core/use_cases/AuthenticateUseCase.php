<?php

namespace src\core\use_cases;


use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;
use src\core\entities\User;
use src\core\entities\Session;
use src\core\services\SessionServiceInterface;

class AuthenticateUseCase
{
  private UsersRepositoryInterface $usersRepository;
  private SessionServiceInterface $sessionService;

  public function __construct(
    UsersRepositoryInterface $usersRepository,
    SessionServiceInterface $sessionService
  ) {
    $this->usersRepository = $usersRepository;
    $this->sessionService = $sessionService;
  }

  /**
   * @param string $login
   * @param string $password
   * @param string|null $ip
   * @param string|null $userAgent
   * @return array{user: User, session: Session}
   * @throws \Exception
   */
  public function execute(string $login, string $password, ?string $ip = null, ?string $userAgent = null): array
  {
    $user = $this->usersRepository->find(new UserSearchRequest(login: $login));
    if (!$user)
      throw new \Exception('User not found');
    if (!$user->getPasswordHash())
      throw new \Exception('Password not set for user');
    $isPasswordValid = password_verify($password, $user->getPasswordHash());
    if (!$isPasswordValid)
      throw new \Exception('Invalid password');
    $session = $this->sessionService->createSession($user, $ip, $userAgent);
    return ['user' => $user, 'session' => $session];
  }
}

?>