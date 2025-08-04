<?php

namespace src\core\services;

interface EncrypterServiceInterface
{
  public function encrypt(string $data): string;
  public function compare(string $data, string $hash): bool;
}