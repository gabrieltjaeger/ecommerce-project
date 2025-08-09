<?php

namespace src\core\use_cases;

use src\core\entities\Product;
use src\core\repositories\ProductsRepositoryInterface;
use src\core\repositories\requests\ProductSearchRequest;

class UpdateProductUseCase
{
  private ProductsRepositoryInterface $productsRepository;

  public function __construct(ProductsRepositoryInterface $productsRepository)
  {
    $this->productsRepository = $productsRepository;
  }

  public function execute(
    int $id,
    string $product,
    string $price,
    string $width,
    string $height,
    string $length,
    string $weight,
    string $url
  ): Product {
    $existing = $this->productsRepository->find(new ProductSearchRequest(id: (string)$id));
    if (!$existing) {
      throw new \Exception('Product not found');
    }

    $existing->setProduct($product);
    $existing->setPrice($price);
    $existing->setWidth($width);
    $existing->setHeight($height);
    $existing->setLength($length);
    $existing->setWeight($weight);
    $existing->setUrl($url);

    $this->productsRepository->update($existing);

    return $existing;
  }
}
?>
