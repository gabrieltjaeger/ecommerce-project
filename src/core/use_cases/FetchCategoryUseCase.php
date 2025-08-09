<?php

namespace src\core\use_cases;

use src\core\entities\Category;
use src\core\repositories\CategoriesRepositoryInterface;
use src\core\repositories\requests\CategorySearchRequest;

class FetchCategoryUseCase
{
  private CategoriesRepositoryInterface $categoriesRepository;

  public function __construct(CategoriesRepositoryInterface $categoriesRepository)
  {
    $this->categoriesRepository = $categoriesRepository;
  }

  public function execute(int $id): ?Category
  {
    return $this->categoriesRepository->find(new CategorySearchRequest(id: $id));
  }
}
?>
