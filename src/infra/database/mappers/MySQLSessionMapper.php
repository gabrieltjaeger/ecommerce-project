<?php

namespace src\infra\database\mappers;

use DateTime;
use src\core\entities\Session;
use src\infra\database\mappers\Mapper;

class MySQLSessionMapper extends Mapper
{
  public static function toDomain(array $data): Session
  {
    return new Session(
      $data["id"] ?? null,
      $data["user_id"] ?? null,
      $data["ip_address"] ?? null,
      $data["user_agent"] ?? null,
      isset($data["created_at"]) ? new DateTime($data["created_at"]) : null,
      isset($data["updated_at"]) ? new DateTime($data["updated_at"]) : null,
    );
  }

  public static function toArray(Session $session): array
  {
    return [
      'id' => $session->getId(),
      'user_id' => $session->getUserId(),
      'ip_address' => $session->getIpAddress(),
      'user_agent' => $session->getUserAgent(),
      'created_at' => $session->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updated_at' => $session->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
  }
}
