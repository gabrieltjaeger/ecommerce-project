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
        // Cria a pessoa primeiro
        $person = $user->getPerson();
        if ($person) {
            $personsRepo = new MySQLPersonsRepository();
            $personsRepo->create($person);
            // Recupera o id da pessoa criada
            $sql = new SQL();
            $stmt = $sql->getConnection()->query('SELECT LAST_INSERT_ID() as id');
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $personId = $result['id'] ?? null;
            if ($personId) {
                $user->setPersonId($personId);
            }
        }
        $sql = new SQL();
        $data = [
            'person_id' => $user->getPersonId(),
            'login' => $user->getLogin(),
            'password_hash' => $user->getPasswordHash(),
            'is_admin' => $user->getIsAdmin(),
            'created_at' => $user->getCreatedAt() ? $user->getCreatedAt()->format('Y-m-d H:i:s') : null,
            'updated_at' => $user->getUpdatedAt() ? $user->getUpdatedAt()->format('Y-m-d H:i:s') : null,
        ];
        $sql->insert(self::TABLE_NAME, $data);
    }


    public function update(User $user): void
    {
        $sql = new SQL();
        $data = [
            'person_id' => $user->getPersonId(),
            'login' => $user->getLogin(),
            'password_hash' => $user->getPasswordHash(),
            'is_admin' => $user->getIsAdmin(),
            'updated_at' => $user->getUpdatedAt() ? $user->getUpdatedAt()->format('Y-m-d H:i:s') : null,
        ];
        $where = [ 'id' => $user->getId() ];
        $sql->update(self::TABLE_NAME, $data, $where);
    }


    public function delete(string $id): void
    {
        $sql = new SQL();
        $where = ['id' => $id];
        $sql->delete(self::TABLE_NAME, $where);
    }
}

?>