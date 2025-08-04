<?php
namespace src\core\entities;

use src\core\entities\Entity;

class Person extends Entity
{
  private ?string $name = null;
  private ?string $email = null;
  private ?string $phone = null;

  public function __construct(
    ?string $id = null,
    ?string $name = null,
    ?string $email = null,
    ?string $phone = null,
    ?\DateTime $created_at = null,
    ?\DateTime $updated_at = null
  ) {
    parent::__construct($id, $created_at, $updated_at);
    $this->name = $name;
    $this->email = $email;
    $this->phone = $phone;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function getPhone(): ?string
  {
    return $this->phone;
  }

  public function setName(string $name): void
  {
    $this->name = $name;
  }

  public function setEmail(string $email): void
  {
    $this->email = $email;
  }

  public function setPhone(string $phone): void
  {
    $this->phone = $phone;
  }

}

?>