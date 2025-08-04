<?php
namespace src\core\entities;

use src\core\entities\Entity;
use src\core\entities\User;
use src\core\entities\Address;

class Cart extends Entity
{
  private $session_id;
  private ?string $user_id = null;
  private ?User $user = null;
  private ?string $shipping_address_id = null;
  private ?Address $shipping_address = null;
  private ?string $freight = null;

  public function __construct(
    ?string $id = null,
    ?string $session_id = null,
    ?string $user_id = null,
    ?User $user = null,
    ?string $shipping_address_id = null,
    ?Address $shipping_address = null,
    ?string $freight = null,
    ?string $created_at = null,
    ?string $updated_at = null
  ) {
    parent::__construct($id, $created_at, $updated_at);
    $this->session_id = $session_id;
    $this->user_id = $user_id;
    $this->user = $user;
    $this->shipping_address_id = $shipping_address_id;
    $this->shipping_address = $shipping_address;
    $this->freight = $freight;
  }

  public function getSessionId(): ?string
  {
    return $this->session_id;
  }

  public function getUserId(): ?string
  {
    return $this->user_id;
  }

  public function getUser(): ?User
  {
    return $this->user;
  }

  public function getShippingAddressId(): ?string
  {
    return $this->shipping_address_id;
  }

  public function getShippingAddress(): ?Address
  {
    return $this->shipping_address;
  }

  public function getFreight(): ?string
  {
    return $this->freight;
  }

  public function setSessionId(string $session_id): void
  {
    $this->session_id = $session_id;
  }

  public function setUserId(string $user_id): void
  {
    $this->user_id = $user_id;
  }

  public function setUser(User $user): void
  {
    $this->user = $user;
    $this->user_id = $user->getId();
  }

  public function setShippingAddressId(string $shipping_address_id): void
  {
    $this->shipping_address_id = $shipping_address_id;
  }

  public function setShippingAddress(Address $shipping_address): void
  {
    $this->shipping_address = $shipping_address;
    $this->shipping_address_id = $shipping_address->getId();
  }

  public function setFreight(string $freight): void
  {
    $this->freight = $freight;
  }

}

?>