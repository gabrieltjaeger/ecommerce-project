<?php
namespace src\core\repositories\requests;

use DateTime;

class AddressSearchRequest
{
  public ?string $id = null;
  public ?string $person_id = null;
  public ?string $address = null;
  public ?string $city = null;
  public ?string $state = null;
  public ?string $country = null;
  public ?string $zip_code = null;
  public ?DateTime $created_at = null;
  public ?DateTime $updated_at = null;

  public function __construct(
    ?string $id = null,
    ?string $person_id = null,
    ?string $address = null,
    ?string $city = null,
    ?string $state = null,
    ?string $country = null,
    ?string $zip_code = null,
    ?DateTime $created_at = null,
    ?DateTime $updated_at = null
  ) {
    $this->id = $id;
    $this->person_id = $person_id;
    $this->address = $address;
    $this->city = $city;
    $this->state = $state;
    $this->country = $country;
    $this->zip_code = $zip_code;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
}
?>