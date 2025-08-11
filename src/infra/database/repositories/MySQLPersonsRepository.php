<?php
namespace src\infra\database\repositories;

use src\core\repositories\PersonsRepositoryInterface;
use src\core\entities\Person;
use src\core\repositories\requests\PersonSearchRequest;
use src\infra\database\mappers\MySQLPersonMapper;
use src\infra\database\SQL;

class MySQLPersonsRepository implements PersonsRepositoryInterface
{
    public const TABLE_NAME = 'persons';

    public function find(PersonSearchRequest $request): ?Person
    {
        var_dump($request);
        echo "<br>";
        echo "<br>";
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];
    [$where, $params] = SQL::buildWhereClause($conditions);
        $selectColumns = SQL::buildSelectColumns([
            'persons' => ['id', 'name', 'email', 'created_at', 'updated_at'],
        ]);
        $query = sprintf(
            'SELECT %s FROM %s %s LIMIT 1',
            $selectColumns,
            self::TABLE_NAME,
            $where
        );
        echo $query;
        echo "<br>";
        echo "<br>";
        $rows = $sql->select($query, $params);
        if (!$rows) {
            return null;
        }
        $row = $rows[0];
        var_dump($row);
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
        return array_map([MySQLPersonMapper::class, 'toDomain'], $rows);
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
