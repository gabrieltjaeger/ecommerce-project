<?php
namespace src\core\repositories;

use src\core\entities\Product;

interface ProductsCategoriesRepositoryInterface
{
  /**
   * @return Product[]
   */
  public function listByCategory(string $categoryId): array;

  /**
   * @return Product[]
   */
  public function listUncategorized(): array;

  public function add(string $categoryId, string $productId): void;

  public function remove(string $categoryId, string $productId): void;
}

?>
