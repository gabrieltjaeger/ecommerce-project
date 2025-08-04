<?php
namespace src\infra\database\mappers;

use src\core\entities\Person;
class MySQLPersonMapper
{
  public static function toDomain(array $data): Person
  {
    $person = new Person(
      $data['id'],
      $data['name'] ?? null,
      $data['email'] ?? null,
      $data['phone'] ?? null,
      $data['created_at'] ?? null,
      $data['updated_at'] ?? null

    );
    return $person;
  }

  public static function toArray(Person $person): array
  {
    return [
      'id' => $person->getId(),
      'name' => $person->getName(),
      'email' => $person->getEmail(),
      'phone' => $person->getPhone(),
      'created_at' => $person->getCreatedAt(),
      'updated_at' => $person->getUpdatedAt()
    ];
  }
}

?>