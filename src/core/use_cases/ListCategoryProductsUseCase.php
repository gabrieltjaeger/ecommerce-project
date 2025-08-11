<?php

namespace src\core\use_cases;

use src\core\repositories\CategoriesRepositoryInterface;
use src\core\repositories\ProductsCategoriesRepositoryInterface;
use src\core\repositories\requests\CategorySearchRequest;
use src\core\entities\Category;

class ListCategoryProductsUseCase
{
  public function __construct(
    private CategoriesRepositoryInterface $categoriesRepository,
    private ProductsCategoriesRepositoryInterface $productsCategoriesRepository
  ) {}

  /**
   * @return array{category: Category, inCategory: array, uncategorized: array}
   */
  public function execute(int $categoryId): array
  {
    $category = $this->categoriesRepository->find(new CategorySearchRequest(id: (string)$categoryId));
    if (!$category) {
      throw new \InvalidArgumentException('Category not found');
    }

    $inCategory = $this->productsCategoriesRepository->listByCategory((string)$categoryId);
    $uncategorized = $this->productsCategoriesRepository->listUncategorized();

    return [
      'category' => $category,
      'inCategory' => $inCategory,
      'uncategorized' => $uncategorized
    ];
  }
}
?>
