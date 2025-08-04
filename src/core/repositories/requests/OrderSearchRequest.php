<?php
namespace src\core\repositories\requests;

use DateTime;

class OrderSearchRequest
{
  public ?string $id = null;
  public ?string $user_id = null;
  public ?DateTime $created_at = null;
  public ?DateTime $updated_at = null;

  public function __construct(
    ?string $id = null,
    ?string $user_id = null,
    ?DateTime $created_at = null,
    ?DateTime $updated_at = null
  ) {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
}
?>