<?php

namespace src\infra\services;

use src\core\services\SessionServiceInterface;
use src\core\entities\User;
use src\core\entities\Session;
use src\core\repositories\SessionsRepositoryInterface;
use src\core\services\CookieServiceInterface;

class SessionService implements SessionServiceInterface
{
  public function __construct(
    private SessionsRepositoryInterface $sessionsRepository,
    private CookieServiceInterface $cookieService
  ) {
  }

  public function createSession(User $user, ?string $ip = null, ?string $userAgent = null): Session
  {
    $sessionId = bin2hex(random_bytes(32));
    $session = new Session(
      $sessionId,
      $user->getId(),
      $ip,
      $userAgent,
      new \DateTime(),
      null
    );
    $this->sessionsRepository->create($session);
    $this->cookieService->setSessionCookie($sessionId);
    return $session;
  }

  public function deleteSession(string $sessionId): void
  {
    $this->sessionsRepository->delete($sessionId);
    $this->cookieService->deleteSessionCookie();
  }

}
