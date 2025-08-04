<?php

namespace src\infra\services;

use src\core\services\CookieServiceInterface;

class CookieService implements CookieServiceInterface
{
  public function setSessionCookie(string $sessionId, int $lifetime = 86400): void
  {
    setcookie('SESSION_ID', $sessionId, [
      'expires' => time() + $lifetime,
      'path' => '/',
      'httponly' => true,
      'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
      'samesite' => 'Strict',
    ]);
  }

  public function deleteSessionCookie(): void
  {
    setcookie('SESSION_ID', '', [
      'expires' => time() - 3600,
      'path' => '/',
      'httponly' => true,
      'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
      'samesite' => 'Strict',
    ]);
  }
}
