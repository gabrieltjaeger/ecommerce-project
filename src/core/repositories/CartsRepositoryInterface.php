<?php
namespace src\core\repositories;

use src\core\entities\Cart;
use src\core\repositories\requests\CartSearchRequest;

interface CartsRepositoryInterface
{
  public function find(CartSearchRequest $request): ?Cart;
  /**
   * @return Cart[]
   */
  public function list(CartSearchRequest $request): array;
  public function create(Cart $cart): void;
  public function update(Cart $cart): void;
  public function delete(string $id): void;
}
