<?php
namespace core\entities;

use core\entities\Entity;
use core\entities\User;

class Order extends Entity
{
  private ?string $cart_id = null;
  private ?string $user_id = null;
  private ?User $user = null;
  private ?string $order_status_id = null;
  private ?string $total_value = null;

  public function __construct(
    ?string $id = null,
    ?string $cart_id = null,
    ?string $user_id = null,
    ?User $user = null,
    ?string $order_status_id = null,
    ?string $total_value = null,
    ?string $created_at = null,
    ?string $updated_at = null
  ) {
    parent::__construct($id, $created_at, $updated_at);
    $this->cart_id = $cart_id;
    $this->user_id = $user_id;
    $this->user = $user;
    $this->order_status_id = $order_status_id;
    $this->total_value = $total_value;
  }

  public function getCartId(): ?string
  {
    return $this->cart_id;
  }

  public function getUserId(): ?string
  {
    return $this->user_id;
  }

  public function getUser(): ?User
  {
    return $this->user;
  }

  public function getOrderStatusId(): ?string
  {
    return $this->order_status_id;
  }

  public function getTotalValue(): ?string
  {
    return $this->total_value;
  }

  public function setCartId(?string $cart_id): void
  {
    $this->cart_id = $cart_id;
  }

  public function setUserId(?string $user_id): void
  {
    $this->user_id = $user_id;
  }

  public function setUser(User $user): void
  {
    $this->user = $user;
    $this->user_id = $this->user->getId();
  }

  public function setOrderStatusId(?string $order_status_id): void
  {
    $this->order_status_id = $order_status_id;
  }

  public function setTotalValue(?string $total_value): void
  {
    $this->total_value = $total_value;
  }
}
?>