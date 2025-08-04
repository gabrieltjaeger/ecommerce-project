<?php
namespace src\core\repositories;

use src\core\entities\Address;
use src\core\repositories\requests\AddressSearchRequest;

interface AddressesRepositoryInterface
{
  public function find(AddressSearchRequest $request): ?Address;
  /**
   * @return Address[]
   */
  public function list(AddressSearchRequest $request): array;
  public function create(Address $address): void;
  public function update(Address $address): void;
  public function delete(string $id): void;
}
