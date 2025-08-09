<?php

namespace src\core\use_cases;

use src\core\repositories\CategoriesRepositoryInterface;

class DeleteCategoryUseCase
{
  private CategoriesRepositoryInterface $categoriesRepository;

  public function __construct(CategoriesRepositoryInterface $categoriesRepository)
  {
    $this->categoriesRepository = $categoriesRepository;
  }

  public function execute(int $id): void
  {
    $this->categoriesRepository->delete($id);
  }
}
?>
