<?php

namespace src\infra\database\repositories;
use src\core\repositories\requests\UserSearchRequest;
use src\core\repositories\UsersRepositoryInterface;
use src\core\entities\User;
use src\infra\database\mappers\MySQLUserMapper;
use src\infra\database\SQL;

class MySQLUsersRepository implements UsersRepositoryInterface
{
    private const TABLE_NAME = 'users';
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

        [$where, $params] = SQL::buildWhereClause($conditions);

        $rows = $sql->select(
            sprintf('SELECT * FROM %s %s LIMIT 1', self::TABLE_NAME, $where),
            $params
        );

        if (!$rows) {
            return null;
        }

        $row = $rows[0];

        return MySQLUserMapper::toDomain($row);
    }


    public function list(UserSearchRequest $request): array
    {
        // Implementation for listing users based on the search request
        return [];
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