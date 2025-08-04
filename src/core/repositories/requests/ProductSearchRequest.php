<?php
namespace src\core\repositories\requests;

use DateTime;

class ProductSearchRequest
{
  public ?string $id = null;
  public ?string $name = null;
  public ?string $category_id = null;
  public ?float $price = null;
  public ?DateTime $created_at = null;
  public ?DateTime $updated_at = null;

  public function __construct(
    ?string $id = null,
    ?string $name = null,
    ?string $category_id = null,
    ?float $price = null,
    ?DateTime $created_at = null,
    ?DateTime $updated_at = null
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->category_id = $category_id;
    $this->price = $price;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
}
?>