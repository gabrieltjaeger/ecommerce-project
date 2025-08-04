<?php
namespace src\core\repositories;

use src\core\entities\Order;
use src\core\repositories\requests\OrderSearchRequest;

interface OrdersRepositoryInterface
{
  public function find(OrderSearchRequest $request): ?Order;
  /**
   * @return Order[]
   */
  public function list(OrderSearchRequest $request): array;
  public function create(Order $order): void;
  public function update(Order $order): void;
  public function delete(string $id): void;
}
