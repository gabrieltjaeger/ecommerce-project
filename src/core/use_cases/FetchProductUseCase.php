<?php

namespace src\core\use_cases;

use src\core\entities\Product;
use src\core\repositories\ProductsRepositoryInterface;
use src\core\repositories\requests\ProductSearchRequest;

class FetchProductUseCase
{
  private ProductsRepositoryInterface $productsRepository;

  public function __construct(ProductsRepositoryInterface $productsRepository)
  {
    $this->productsRepository = $productsRepository;
  }

  public function execute(int $id): ?Product
  {
    return $this->productsRepository->find(new ProductSearchRequest(id: (string)$id));
  }
}
?>
