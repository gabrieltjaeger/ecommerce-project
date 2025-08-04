<?php
namespace src\infra\database\mappers;

use DateTime;
use src\core\entities\Address;
use src\infra\database\mappers\Mapper;

class MySQLAddressMapper extends Mapper
{
  public static function toDomain(array $data): Address
  {
    return new Address(
      $data["id"] ?? null,
      $data["person_id"] ?? null,
      null,
      $data["address"] ?? null,
      $data["complement"] ?? null,
      $data["city"] ?? null,
      $data["state"] ?? null,
      $data["country"] ?? null,
      $data["zip_code"] ?? null,
      isset($data["created_at"]) ? new DateTime($data["created_at"]) : null,
      isset($data["updated_at"]) ? new DateTime($data["updated_at"]) : null
    );
  }

  public static function toArray(Address $address): array
  {
    return [
      'id' => $address->getId(),
      'person_id' => $address->getPersonId(),
      'address' => $address->getAddress(),
      'complement' => $address->getComplement(),
      'city' => $address->getCity(),
      'state' => $address->getState(),
      'country' => $address->getCountry(),
      'zip_code' => $address->getZipCode(),
      'created_at' => $address->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updated_at' => $address->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
  }
}
