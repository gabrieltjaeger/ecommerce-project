<?php
namespace src\core\use_cases;

use src\core\repositories\CategoriesRepositoryInterface;
use src\core\repositories\ProductsRepositoryInterface;
use src\core\repositories\ProductsCategoriesRepositoryInterface;
use src\core\repositories\requests\CategorySearchRequest;
use src\core\repositories\requests\ProductSearchRequest;

class AddProductToCategoryUseCase
{
  public function __construct(
    private CategoriesRepositoryInterface $categoriesRepository,
    private ProductsRepositoryInterface $productsRepository,
    private ProductsCategoriesRepositoryInterface $productsCategoriesRepository
  ) {}

  public function execute(int $categoryId, int $productId): void
  {
    $category = $this->categoriesRepository->find(new CategorySearchRequest(id: (string)$categoryId));
    if (!$category) {
      throw new \InvalidArgumentException('Category not found');
    }
    $product = $this->productsRepository->find(new ProductSearchRequest(id: (string)$productId));
    if (!$product) {
      throw new \InvalidArgumentException('Product not found');
    }
    $this->productsCategoriesRepository->add((string)$categoryId, (string)$productId);
  }
}
?>
