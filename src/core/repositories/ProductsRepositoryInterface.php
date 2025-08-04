<?php
namespace src\core\repositories;

use src\core\repositories\requests\ProductSearchRequest;
use src\core\entities\Product;

interface ProductsRepositoryInterface
{
  public function find(ProductSearchRequest $request): ?Product;
  /**
   * @return Product[]
   */
  public function list(ProductSearchRequest $request): array;
  public function create(Product $product): void;
  public function update(Product $product): void;
  public function delete(string $id): void;
}
