<?php

namespace src\core\services;

use src\core\entities\User;
use src\core\entities\Session;

interface SessionServiceInterface
{

  /**
   * Cria e persiste uma sessão para o usuário autenticado.
   * @param User $user
   * @param string|null $ip
   * @param string|null $userAgent
   * @return Session
   */
  public function createSession(User $user, ?string $ip = null, ?string $userAgent = null): Session;

  /**
   * Deleta uma sessão existente.
   * @param string $sessionId
   * @return void
   */
  public function deleteSession(string $sessionId): void;

}
