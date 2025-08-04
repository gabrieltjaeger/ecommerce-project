<?php
namespace src\infra\database\mappers;

use DateTime;
use src\core\entities\Person;
use src\infra\database\mappers\Mapper;


class MySQLPersonMapper extends Mapper
{
  public static function toDomain(array $data): Person
  {
    $person = new Person(
      $data['persons_id'] ?? null,
      $data['persons_name'] ?? null,
      $data['persons_email'] ?? null,
      $data['persons_phone'] ?? null,
      isset($data['persons_created_at']) ? new DateTime($data['persons_created_at']) : null,
      isset($data['persons_updated_at']) ? new DateTime($data['persons_updated_at']) : null
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
      'created_at' => $person->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updated_at' => $person->getUpdatedAt()?->format('Y-m-d H:i:s')
    ];
  }
}


?>