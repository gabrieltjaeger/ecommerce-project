<?php

namespace src\infra\database\mappers;

use DateTime;
use src\core\entities\User;
use src\infra\database\mappers\MySQLPersonMapper;
class MySQLUserMapper
{
  public static function toDomain(array $data): User
  {
    $user = new User(
      $data["id"] ?? null,
      $data["person_id"] ?? null,
      isset($data["person"]) ? MySQLPersonMapper::toDomain($data["person"]) : null,
      $data["login"] ?? null,
      $data["password_hash"],
      isset($data["is_admin"]) ? (bool) $data["is_admin"] : null,
      isset($data["created_at"]) ? new DateTime($data["created_at"]) : null,
      isset($data["updated_at"]) ? new DateTime($data["updated_at"]) : null
    );
    return $user;
  }

  public static function toArray(User $user): array
  {
    return [
      'id' => $user->getId(),
      'person_id' => $user->getPersonId(),
      'login' => $user->getLogin(),
      'is_admin' => $user->getIsAdmin(),
      'created_at' => $user->getCreatedAt(),
      'updated_at' => $user->getUpdatedAt()
    ];
  }
}

?>