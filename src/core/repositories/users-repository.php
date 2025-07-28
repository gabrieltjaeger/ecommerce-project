<?php

use core\repositories\requests\UserSearchRequest;
use core\entities\User;

interface UsersRepositoryInterface
{
  public function find(UserSearchRequest $request): ?User;

  /**
   * @return User[]
   */
  public function list(UserSearchRequest $request): array;
  public function create(User $user): void;
  public function update(User $user): void;
  public function delete(string $id): void;
}

?>