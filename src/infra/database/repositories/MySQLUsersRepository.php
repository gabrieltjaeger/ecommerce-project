<?php

namespace src\infra\database\repositories;
use src\core\repositories\requests\UserSearchRequest;
use src\core\repositories\UsersRepositoryInterface;
use src\core\entities\User;
use src\infra\database\mappers\MySQLUserMapper;
use src\infra\database\SQL;
use src\infra\database\repositories\MySQLPersonsRepository;

class MySQLUsersRepository implements UsersRepositoryInterface
{
    public const TABLE_NAME = 'users';
    public function find(UserSearchRequest $request): ?User
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'person_id' => $request->person_id,
            'login' => $request->login,
            'is_admin' => $request->is_admin,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];

        [$where, $params] = SQL::buildWhereClause($conditions, self::TABLE_NAME);

        $selectColumns = SQL::buildSelectColumns([
            'users' => ['id', 'person_id', 'login', 'password_hash', 'is_admin', 'created_at', 'updated_at'],
            'persons' => ['id', 'name', 'email', 'created_at', 'updated_at'],
        ]);


        $query = sprintf(
            'SELECT %s FROM %s 
             LEFT JOIN %s ON users.person_id = persons.id %s LIMIT 1',
            $selectColumns,
            self::TABLE_NAME,
            MySQLPersonsRepository::TABLE_NAME,
            $where
        );

        $rows = $sql->select($query, $params);


        if (!$rows) {
            return null;
        }

        $row = $rows[0];

        return MySQLUserMapper::toDomain($row);
    }


    public function list(UserSearchRequest $request): array
    {
        $sql = new SQL();

        $conditions = [
            'id' => $request->id,
            'person_id' => $request->person_id,
            'login' => $request->login,
            'is_admin' => $request->is_admin,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];

        [$where, $params] = SQL::buildWhereClause($conditions, self::TABLE_NAME);

        $selectColumns = SQL::buildSelectColumns([
            'users' => ['id', 'person_id', 'login', 'password_hash', 'is_admin', 'created_at', 'updated_at'],
            'persons' => ['id', 'name', 'email', 'created_at', 'updated_at'],
        ]);

        $query = sprintf(
            'SELECT %s FROM %s 
            LEFT JOIN %s ON users.person_id = persons.id %s',
            $selectColumns,
            self::TABLE_NAME,
            MySQLPersonsRepository::TABLE_NAME,
            $where
        );
        $rows = $sql->select($query, $params);

        if (!$rows) {
            return [];
        }

        return array_map(function ($row) {
            return MySQLUserMapper::toDomain($row);
        }, $rows);
    }

    public function create(User $user): void
    {
        // Implementation for creating a new user
    }

    public function update(User $user): void
    {
        // Implementation for updating an existing user
    }

    public function delete(string $id): void
    {
        // Implementation for deleting a user by ID
    }
}

?>