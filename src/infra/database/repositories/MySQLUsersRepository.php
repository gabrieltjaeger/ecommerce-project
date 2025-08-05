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
        $person = $user->getPerson();
        if (!$person) {
            throw new \InvalidArgumentException('User must have a Person to be created.');
        }

        $sql = new SQL();
        $conn = $sql->getConnection();

        $stmt = $conn->prepare('CALL create_user_with_person(?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $person->getName(),
            $person->getEmail(),
            $person->getPhone() === '' ? null : $person->getPhone(),
            $user->getLogin(),
            $user->getPasswordHash(),
            $user->getIsAdmin()
        ]);
    }


    public function update(User $user): void
    {
        $person = $user->getPerson();
        if (!$person) {
            throw new \InvalidArgumentException('User must have a Person to be updated.');
        }

        $sql = new SQL();
        $conn = $sql->getConnection();

        $stmt = $conn->prepare('CALL update_user_with_person(?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $person->getId(),
            $person->getName(),
            $person->getEmail(),
            $person->getPhone() === '' ? null : $person->getPhone(),
            $user->getLogin(),
            $user->getPasswordHash(),
            (int)$user->getIsAdmin()
        ]);
    }


    public function delete(User $user): void
    {
        $person = $user->getPerson();
        if (!$person) {
            throw new \InvalidArgumentException('User must have a Person to be deleted.');
        }

        $personId = $person->getId();
        if (!$personId) {
            throw new \InvalidArgumentException('User must have a valid Person ID to be deleted.');
        }

        $sql = new SQL();
        $conn = $sql->getConnection();



        $stmt = $conn->prepare('CALL delete_user_with_person(?)');

        var_dump($personId);
        var_dump($stmt);

        $stmt->execute([$personId]);


    }
}

?>