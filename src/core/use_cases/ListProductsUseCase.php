<?php

namespace src\core\use_cases;

use src\core\repositories\ProductsRepositoryInterface;
use src\core\repositories\requests\ProductSearchRequest;

class ListProductsUseCase
{
  private ProductsRepositoryInterface $productsRepository;

  public function __construct(ProductsRepositoryInterface $productsRepository)
  {
    $this->productsRepository = $productsRepository;
  }

  public function execute(): array
  {
    return $this->productsRepository->list(new ProductSearchRequest());
  }
}
?>
