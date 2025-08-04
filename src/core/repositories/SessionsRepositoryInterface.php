<?php
namespace src\core\repositories;

use src\core\entities\Session;
use src\core\repositories\requests\SessionSearchRequest;

interface SessionsRepositoryInterface
{
  public function find(SessionSearchRequest $request): ?Session;

  /**
   * @return Session[]
   */
  public function list(SessionSearchRequest $request): array;
  public function create(Session $session): void;
  public function update(Session $session): void;
  public function delete(string $id): void;
}
