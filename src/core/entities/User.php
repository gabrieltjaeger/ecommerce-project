<?php
namespace core\entities;

use core\entities\Entity;
use core\entities\Person;

class User extends Entity
{
  private ?string $person_id = null;
  private ?Person $person = null;
  private ?string $login = null;
  private ?bool $is_admin = null;

  public function __construct(
    ?string $id = null,
    ?string $person_id = null,
    ?Person $person = null,
    ?string $login = null,
    ?bool $is_admin = null,
    ?string $created_at = null,
    ?string $updated_at = null
  ) {
    parent::__construct($id, $created_at, $updated_at);
    $this->person_id = $person_id;
    $this->person = $person;
    $this->login = $login;
    $this->is_admin = $is_admin;
  }

  public function getPersonId(): ?string
  {
    return $this->person_id;
  }

  public function getPerson(): ?Person
  {
    return $this->person;
  }

  public function getLogin(): ?string
  {
    return $this->login;
  }

  public function getIsAdmin(): ?bool
  {
    return $this->is_admin;
  }

  public function setPersonId(string $person_id): void
  {
    $this->person_id = $person_id;
  }

  public function setPerson(Person $person): void
  {
    $this->person = $person;
    $this->person_id = $this->person->getId();
  }

  public function setLogin(string $login): void
  {
    $this->login = $login;
  }

  public function setIsAdmin(bool $is_admin): void
  {
    $this->is_admin = $is_admin;
  }
}

?>