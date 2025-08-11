<?php

namespace src\infra\database\mappers;

use DateTime;
use src\core\entities\Product;
use src\infra\database\mappers\Mapper;

class MySQLProductMapper extends Mapper
{
  public static function toDomain(array $row): Product
  {
    return new Product(
      $row['id'] ?? null,
      $row['product'] ?? null,
      $row['price'] ?? null,
      $row['width'] ?? null,
      $row['height'] ?? null,
      $row['length'] ?? null,
      $row['weight'] ?? null,
      $row['url'] ?? null,
      isset($row['created_at']) ? new DateTime($row['created_at']) : null,
      isset($row['updated_at']) ? new DateTime($row['updated_at']) : null
    );
  }

  public static function toArray(Product $product): array
  {
    return [
      'id' => $product->getId(),
      'product' => $product->getProduct(),
      'price' => $product->getPrice(),
      'width' => $product->getWidth(),
      'height' => $product->getHeight(),
      'length' => $product->getLength(),
      'weight' => $product->getWeight(),
      'url' => $product->getUrl(),
      'created_at' => $product->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updated_at' => $product->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
  }
}
