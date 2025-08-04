<?php

namespace src\core\repositories\requests;

use DateTime;

class UserSearchRequest
{
  public ?string $id = null;
  public ?string $person_id = null;
  public ?string $login = null;
  public ?bool $is_admin = null;
  public ?DateTime $created_at = null;
  public ?DateTime $updated_at = null;
  public ?int $page = null;

  public function __construct(
    ?string $id = null,
    ?string $person_id = null,
    ?string $login = null,
    ?bool $is_admin = null,
    ?DateTime $created_at = null,
    ?DateTime $updated_at = null,
    ?int $page = null
  ) {
    $this->id = $id;
    $this->person_id = $person_id;
    $this->login = $login;
    $this->is_admin = $is_admin;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->page = $page;
  }
}
?>