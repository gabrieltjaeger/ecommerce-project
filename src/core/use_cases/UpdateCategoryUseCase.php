<?php

namespace src\core\use_cases;

use src\core\repositories\CategoriesRepositoryInterface;
use src\core\repositories\requests\CategorySearchRequest;

class UpdateCategoryUseCase
{
  private CategoriesRepositoryInterface $categoriesRepository;

  public function __construct(CategoriesRepositoryInterface $categoriesRepository)
  {
    $this->categoriesRepository = $categoriesRepository;
  }

  public function execute(int $id, string $category): void
  {
    $existing = $this->categoriesRepository->find(new CategorySearchRequest(id: $id));
    if (!$existing) {
      throw new \InvalidArgumentException('Category not found');
    }

    $duplicate = $this->categoriesRepository->find(new CategorySearchRequest(category: $category));
    if ($duplicate && $duplicate->getId() != $id) {
      throw new \Exception('Category with this name already exists');
    }

    $existing->setCategory($category);
    $this->categoriesRepository->update($existing);
  }
}
?>
