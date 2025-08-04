<?php

namespace src\infra\services;

use src\core\services\EncrypterServiceInterface;

class EncrypterService implements EncrypterServiceInterface
{
  public function encrypt(string $data): string
  {
    return password_hash($data, PASSWORD_BCRYPT);
  }

  public function compare(string $data, string $hash): bool
  {
    return password_verify($data, $hash);
  }
}

?>