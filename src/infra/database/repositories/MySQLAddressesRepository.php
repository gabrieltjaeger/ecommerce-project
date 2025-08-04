<?php
namespace src\infra\database\repositories;

use src\core\repositories\AddressesRepositoryInterface;
use src\core\repositories\requests\AddressSearchRequest;
use src\core\entities\Address;
use src\infra\database\mappers\MySQLAddressMapper;
use src\infra\database\SQL;

class MySQLAddressesRepository implements AddressesRepositoryInterface
{
  private const TABLE_NAME = 'addresses';

  public function find(AddressSearchRequest $request): ?Address
  {
    $sql = new SQL();
    $conditions = [
      'id' => $request->id,
      'person_id' => $request->person_id,
      'address' => $request->address,
      'city' => $request->city,
      'state' => $request->state,
      'country' => $request->country,
      'zip_code' => $request->zip_code,
      'created_at' => $request->created_at,
      'updated_at' => $request->updated_at,
    ];
    [$where, $params] = SQL::buildWhereClause($conditions);
    $rows = $sql->select(
      sprintf('SELECT * FROM %s %s LIMIT 1', self::TABLE_NAME, $where),
      $params
    );
    if (!$rows) {
      return null;
    }
    $row = $rows[0];
    return MySQLAddressMapper::toDomain($row);
  }

  public function list(AddressSearchRequest $request): array
  {
    $sql = new SQL();
    $conditions = [
      'id' => $request->id,
      'person_id' => $request->person_id,
      'address' => $request->address,
      'city' => $request->city,
      'state' => $request->state,
      'country' => $request->country,
      'zip_code' => $request->zip_code,
      'created_at' => $request->created_at,
      'updated_at' => $request->updated_at,
    ];
    [$where, $params] = SQL::buildWhereClause($conditions);
    $rows = $sql->select(
      sprintf('SELECT * FROM %s %s', self::TABLE_NAME, $where),
      $params
    );
    return array_map([MySQLAddressMapper::class, 'toDomain'], $rows);
  }

  public function create(Address $address): void
  {
    $sql = new SQL();
    $data = MySQLAddressMapper::toArray($address);
    $sql->insert(self::TABLE_NAME, $data);
  }

  public function update(Address $address): void
  {
    $sql = new SQL();
    $data = MySQLAddressMapper::toArray($address);
    $sql->update(self::TABLE_NAME, $data, ['id' => $address->getId()]);
  }

  public function delete(string $id): void
  {
    $sql = new SQL();
    $sql->delete(self::TABLE_NAME, ['id' => $id]);
  }
}
