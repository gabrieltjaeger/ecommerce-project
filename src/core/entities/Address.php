<?php
namespace core\entities;

use core\entities\Entity;
use core\entities\Person;

class Address extends Entity
{
  private ?string $person_id = null;
  private ?Person $person = null;
  private ?string $address = null;
  private ?string $complement = null;
  private ?string $city = null;
  private ?string $state = null;
  private ?string $country = null;
  private ?string $zip_code = null;

  private function __construct(?string $id = null, ?string $person_id = null, ?Person $person = null, ?string $address = null, ?string $complement = null, ?string $city = null, ?string $state = null, ?string $country = null, ?string $zip_code = null, ?string $created_at = null, ?string $updated_at = null)
  {
    parent::__construct($id, $created_at, $updated_at);
    $this->person_id = $person_id;
    $this->person = $person;
    $this->address = $address;
    $this->complement = $complement;
    $this->city = $city;
    $this->state = $state;
    $this->country = $country;
    $this->zip_code = $zip_code;
  }

  public function getPersonId(): ?string
  {
    return $this->person_id;
  }

  public function getPerson(): ?Person
  {
    return $this->person;
  }

  public function getAddress(): ?string
  {
    return $this->address;
  }

  public function getComplement(): ?string
  {
    return $this->complement;
  }

  public function getCity(): ?string
  {
    return $this->city;
  }

  public function getState(): ?string
  {
    return $this->state;
  }

  public function getCountry(): ?string
  {
    return $this->country;
  }

  public function getZipCode(): ?string
  {
    return $this->zip_code;
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

  public function setAddress(string $address): void
  {
    $this->address = $address;
  }

  public function setComplement(string $complement): void
  {
    $this->complement = $complement;
  }

  public function setCity(string $city): void
  {
    $this->city = $city;
  }

  public function setState(string $state): void
  {
    $this->state = $state;
  }

  public function setCountry(string $country): void
  {
    $this->country = $country;
  }

  public function setZipCode(string $zip_code): void
  {
    $this->zip_code = $zip_code;
  }

}

?>