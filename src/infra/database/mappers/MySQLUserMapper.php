<?php

namespace src\infra\database\mappers;

use DateTime;
use src\core\entities\User;
use src\infra\database\mappers\Mapper;
use src\infra\database\mappers\MySQLPersonMapper;
class MySQLUserMapper extends Mapper
{
  public static function toDomain(array $data): User
  {
    $personData = self::getValuesWithPrefix($data, 'persons');
    $userData = self::getValuesWithPrefix($data, 'users');
    $user = new User(
      $userData["users_id"] ?? null,
      $userData["users_person_id"] ?? null,
      $personData ? MySQLPersonMapper::toDomain($personData) : null,
      $userData["users_login"] ?? null,
      $userData["users_password_hash"] ?? null,
      isset($userData["users_is_admin"]) ? (bool) $userData["users_is_admin"] : null,
      isset($userData["users_created_at"]) ? new DateTime($userData["users_created_at"]) : null,
      isset($userData["users_updated_at"]) ? new DateTime($userData["users_updated_at"]) : null
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