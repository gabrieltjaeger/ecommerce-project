<?php
namespace src\infra\database\mappers;

use src\core\entities\Category;

class MySQLCategoryMapper
{
  public static function toDomain(array $row): Category
  {
    return new Category(
      $row['id'] ?? null,
      $row['category'] ?? null,
      $row['created_at'] ?? null,
      $row['updated_at'] ?? null
    );
  }

  public static function toArray(Category $category): array
  {
    return [
      'id' => $category->getId(),
      'category' => $category->getCategory(),
      'created_at' => $category->getCreatedAt()?->format('Y-m-d H:i:s'),
      'updated_at' => $category->getUpdatedAt()?->format('Y-m-d H:i:s'),
    ];
  }
}
