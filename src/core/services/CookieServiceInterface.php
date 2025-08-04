<?php

namespace src\core\services;

interface CookieServiceInterface
{
  /**
   * Define um cookie de sessão seguro.
   * @param string $sessionId
   * @param int $lifetime
   */
  public function setSessionCookie(string $sessionId, int $lifetime = 86400): void;

  /**
   * Remove o cookie de sessão.
   */
  public function deleteSessionCookie(): void;
}
