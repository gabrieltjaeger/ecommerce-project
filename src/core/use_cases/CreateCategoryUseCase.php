<?php

namespace src\core\use_cases;

use src\core\entities\Category;
use src\core\repositories\CategoriesRepositoryInterface;
use src\core\repositories\requests\CategorySearchRequest;

class CreateCategoryUseCase
{
  private CategoriesRepositoryInterface $categoriesRepository;

  public function __construct(CategoriesRepositoryInterface $categoriesRepository)
  {
    $this->categoriesRepository = $categoriesRepository;
  }

  public function execute(string $category): Category
  {
    $existing = $this->categoriesRepository->find(new CategorySearchRequest(category: $category));
    if ($existing) {
      throw new \Exception('Category with this name already exists');
    }

    $categoryEntity = new Category(
      id: null,
      category: $category
    );

    $this->categoriesRepository->create($categoryEntity);

    return $categoryEntity;
  }
}
?>
