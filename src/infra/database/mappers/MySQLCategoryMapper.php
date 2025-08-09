<?php
namespace src\infra\database\mappers;

use src\core\entities\Category;
use src\infra\database\mappers\Mapper;

class MySQLCategoryMapper extends Mapper
{
  public static function toDomain(array $row): Category
  {
    return new Category(
      (int) $row['id'] ?? null,
      (string) $row['category'] ?? null,
      isset($row['created_at']) ? new \DateTime($row['created_at']) : null,
      isset($row['updated_at']) ? new \DateTime($row['updated_at']) : null
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
