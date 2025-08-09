<?php

namespace src\core\use_cases;

use src\core\entities\Product;
use src\core\repositories\ProductsRepositoryInterface;
use src\core\repositories\requests\ProductSearchRequest;

class CreateProductUseCase
{
  private ProductsRepositoryInterface $productsRepository;

  public function __construct(ProductsRepositoryInterface $productsRepository)
  {
    $this->productsRepository = $productsRepository;
  }

  public function execute(
    string $product,
    string $price,
    string $width,
    string $height,
    string $length,
    string $weight,
    string $url
  ): Product {
    $existing = $this->productsRepository->find(new ProductSearchRequest(name: $product));
    if ($existing) {
      throw new \Exception('Product with this name already exists');
    }

    $productEntity = new Product(
      id: null,
      product: $product,
      price: $price,
      width: $width,
      height: $height,
      length: $length,
      weight: $weight,
      url: $url
    );

    $this->productsRepository->create($productEntity);

    return $productEntity;
  }
}
?>
