<?php
namespace src\core\repositories\requests;

use DateTime;

class PersonSearchRequest
{
  public ?string $id = null;
  public ?string $name = null;
  public ?string $email = null;
  public ?string $phone = null;
  public ?DateTime $created_at = null;
  public ?DateTime $updated_at = null;

  public function __construct(
    ?string $id = null,
    ?string $name = null,
    ?string $email = null,
    ?string $phone = null,
    ?DateTime $created_at = null,
    ?DateTime $updated_at = null
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->phone = $phone;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
}
?>