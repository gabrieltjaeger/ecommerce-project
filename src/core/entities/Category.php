<?php
namespace src\core\entities;

use src\core\entities\Entity;

class Category extends Entity
{
  private ?string $category = null;

  public function __construct(
    ?string $id = null,
    ?string $category = null,
    ?string $created_at = null,
    ?string $updated_at = null
  ) {
    parent::__construct($id, $created_at, $updated_at);
    $this->category = $category;
  }

  public function getCategory(): ?string
  {
    return $this->category;
  }

  public function setCategory(?string $category): void
  {
    $this->category = $category;
  }

}

?>