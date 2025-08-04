<?php

namespace src\core\repositories\requests;

use DateTime;

class SessionSearchRequest
{
  public ?string $id = null;
  public ?string $user_id = null;
  public ?string $ip_address = null;
  public ?string $user_agent = null;
  public ?DateTime $created_at = null;
  public ?DateTime $updated_at = null;

  public function __construct(
    ?string $id = null,
    ?string $user_id = null,
    ?string $ip_address = null,
    ?string $user_agent = null,
    ?DateTime $created_at = null,
    ?DateTime $updated_at = null
  ) {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->ip_address = $ip_address;
    $this->user_agent = $user_agent;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
}
?>