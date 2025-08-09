<?php

namespace src\core\use_cases;

use src\core\repositories\ProductsRepositoryInterface;

class DeleteProductUseCase
{
  private ProductsRepositoryInterface $productsRepository;

  public function __construct(ProductsRepositoryInterface $productsRepository)
  {
    $this->productsRepository = $productsRepository;
  }

  public function execute(int $id): void
  {
    $this->productsRepository->delete((string)$id);
  }
}
?>
