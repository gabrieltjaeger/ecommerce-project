<?php

namespace src\infra\database\repositories;

use src\core\repositories\SessionsRepositoryInterface;
use src\core\repositories\requests\SessionSearchRequest;
use src\core\entities\Session;
use src\infra\database\mappers\MySQLSessionMapper;
use src\infra\database\SQL;

class MySQLSessionsRepository implements SessionsRepositoryInterface
{
    private const TABLE_NAME = 'sessions';

    public function find(SessionSearchRequest $request): ?Session
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'user_id' => $request->user_id,
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
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
        return MySQLSessionMapper::toDomain($row);
    }


    public function list(SessionSearchRequest $request): array
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'user_id' => $request->user_id,
            'ip_address' => $request->ip_address,
            'user_agent' => $request->user_agent,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];
        [$where, $params] = SQL::buildWhereClause($conditions);
        $rows = $sql->select(
            sprintf('SELECT * FROM %s %s', self::TABLE_NAME, $where),
            $params
        );
        return array_map([\src\infra\database\mappers\MySQLSessionMapper::class, 'toDomain'], $rows);
    }


    public function create(Session $session): void
    {
        $sql = new SQL();
        $data = [
            'id' => $session->getId(),
            'user_id' => $session->getUserId(),
            'ip_address' => $session->getIpAddress(),
            'user_agent' => $session->getUserAgent(),
            'created_at' => $session->getCreatedAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $session->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
        $sql->insert(self::TABLE_NAME, $data);
    }


    public function update(Session $session): void
    {
        $sql = new SQL();
        $data = [
            'user_id' => $session->getUserId(),
            'ip_address' => $session->getIpAddress(),
            'user_agent' => $session->getUserAgent(),
            'created_at' => $session->getCreatedAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $session->getUpdatedAt()?->format('Y-m-d H:i:s'),
        ];
        $sql->update(self::TABLE_NAME, $data, ['id' => $session->getId()]);
    }


    public function delete(string $id): void
    {
        $sql = new SQL();
        $sql->delete(self::TABLE_NAME, ['id' => $id]);
    }
}
