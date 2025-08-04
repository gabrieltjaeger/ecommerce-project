<?php
namespace src\core\repositories\requests;

use DateTime;

class CategorySearchRequest
{
  public ?string $id = null;
  public ?string $category = null;
  public ?DateTime $created_at = null;
  public ?DateTime $updated_at = null;

  public function __construct(
    ?string $id = null,
    ?string $category = null,
    ?DateTime $created_at = null,
    ?DateTime $updated_at = null
  ) {
    $this->id = $id;
    $this->category = $category;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
}
?>