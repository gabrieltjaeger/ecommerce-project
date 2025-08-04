<?php
namespace src\infra\database\repositories;

use src\core\repositories\PersonsRepositoryInterface;
use src\core\entities\Person;
use src\core\repositories\requests\PersonSearchRequest;
use src\infra\database\mappers\MySQLPersonMapper;
use src\infra\database\SQL;

class MySQLPersonsRepository implements PersonsRepositoryInterface
{
    private const TABLE_NAME = 'persons';

    public function find(PersonSearchRequest $request): ?Person
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'name' => $request->name,
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
        return MySQLPersonMapper::toDomain($row);
    }

    public function list(PersonSearchRequest $request): array
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'name' => $request->name,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];
        [$where, $params] = SQL::buildWhereClause($conditions);
        $rows = $sql->select(
            sprintf('SELECT * FROM %s %s', self::TABLE_NAME, $where),
            $params
        );
        return array_map([MySQLPersonMapper::class, 'fromArray'], $rows);
    }

    public function create(Person $person): void
    {
        $sql = new SQL();
        $data = MySQLPersonMapper::toArray($person);
        $sql->insert(self::TABLE_NAME, $data);
    }

    public function update(Person $person): void
    {
        $sql = new SQL();
        $data = MySQLPersonMapper::toArray($person);
        $sql->update(self::TABLE_NAME, $data, ['id' => $person->getId()]);
    }

    public function delete(string $id): void
    {
        $sql = new SQL();
        $sql->delete(self::TABLE_NAME, ['id' => $id]);
    }
}
