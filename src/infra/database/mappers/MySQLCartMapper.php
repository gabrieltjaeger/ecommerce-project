<?php
namespace src\infra\database\mappers;

use src\core\entities\Cart;

class MySQLCartMapper
{
  public static function toDomain(array $row): Cart
  {
    return new Cart(
      $row['id'] ?? null,
      $row['user_id'] ?? null,
      isset($row['created_at']) ? $row['created_at'] : null,
      isset($row['updated_at']) ? $row['updated_at'] : null
    );
  }

  public static function toArray(Cart $cart): array
  {
    return [
      'id' => $cart->getId(),
      'user_id' => $cart->getUserId(),
      'created_at' => $cart->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updated_at' => $cart->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
  }
}
