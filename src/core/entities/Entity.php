<?php
namespace core\entities;

abstract class Entity
{
  protected $id;
  protected $created_at;
  protected $updated_at;

  protected function __construct(
    ?string $id = null,
    ?\DateTime $created_at = null,
    ?\DateTime $updated_at = null
  ) {
    $this->id = $id;
    $this->created_at = $created_at ?? new \DateTime();
    $this->updated_at = $updated_at;
  }

  public function getId(): ?string
  {
    return $this->id;
  }
  public function getCreatedAt(): ?\DateTime
  {
    return $this->created_at;
  }
  public function getUpdatedAt(): ?\DateTime
  {
    return $this->updated_at;
  }

  public function setCreatedAt(\DateTime $created_at): void
  {
    $this->created_at = $created_at;
  }
  public function setUpdatedAt(\DateTime $updated_at): void
  {
    $this->updated_at = $updated_at;
  }

  public function touch(): void
  {
    $this->updated_at = new \DateTime();
  }
}

?>