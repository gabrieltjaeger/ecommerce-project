<?php
namespace src\infra\database\mappers;

use src\core\entities\Order;
use src\infra\database\mappers\Mapper;

class MySQLOrderMapper extends Mapper
{
  public static function toDomain(array $row): Order
  {
    return new Order(
      $row['id'] ?? null,
      $row['user_id'] ?? null,
      isset($row['created_at']) ? $row['created_at'] : null,
      isset($row['updated_at']) ? $row['updated_at'] : null
    );
  }

  public static function toArray(Order $order): array
  {
    return [
      'id' => $order->getId(),
      'user_id' => $order->getUserId(),
      'created_at' => $order->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updated_at' => $order->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
  }
}
