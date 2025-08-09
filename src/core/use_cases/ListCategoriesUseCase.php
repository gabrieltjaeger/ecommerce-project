<?php

namespace src\core\use_cases;

use src\core\repositories\CategoriesRepositoryInterface;
use src\core\repositories\requests\CategorySearchRequest;

class ListCategoriesUseCase
{
  private CategoriesRepositoryInterface $categoriesRepository;

  public function __construct(CategoriesRepositoryInterface $categoriesRepository)
  {
    $this->categoriesRepository = $categoriesRepository;
  }

  public function execute(?string $category = null): array
  {
    return $this->categoriesRepository->list(new CategorySearchRequest(category: $category));
  }
}
?>
