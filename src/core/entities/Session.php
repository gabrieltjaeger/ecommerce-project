<?php
namespace src\core\entities;

use src\core\entities\Entity;

class Session extends Entity
{
  private ?string $user_id = null;
  private ?string $ip_address = null;
  private ?string $user_agent = null;

  public function __construct(
    ?string $id = null,
    ?string $user_id = null,
    ?string $ip_address = null,
    ?string $user_agent = null,
    ?\DateTime $created_at = null,
    ?\DateTime $updated_at = null
  ) {
    parent::__construct($id, $created_at, $updated_at);
    $this->user_id = $user_id;
    $this->ip_address = $ip_address;
    $this->user_agent = $user_agent;
  }

  public function getUserId(): ?string
  {
    return $this->user_id;
  }
  public function getIpAddress(): ?string
  {
    return $this->ip_address;
  }
  public function getUserAgent(): ?string
  {
    return $this->user_agent;
  }

  public function setUserId(string $user_id): void
  {
    $this->user_id = $user_id;
  }
  public function setIpAddress(string $ip_address): void
  {
    $this->ip_address = $ip_address;
  }
  public function setUserAgent(string $user_agent): void
  {
    $this->user_agent = $user_agent;
  }
}
