<?php
namespace src\infra\database\repositories;

use src\core\repositories\OrdersRepositoryInterface;
use src\core\entities\Order;
use src\core\repositories\requests\OrderSearchRequest;
use src\infra\database\mappers\MySQLOrderMapper;
use src\infra\database\SQL;

class MySQLOrdersRepository implements OrdersRepositoryInterface
{
    public const TABLE_NAME = 'orders';

    public function find(OrderSearchRequest $request): ?Order
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'user_id' => $request->user_id,
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
        return MySQLOrderMapper::toDomain($row);
    }

    public function list(OrderSearchRequest $request): array
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'user_id' => $request->user_id,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];
        [$where, $params] = SQL::buildWhereClause($conditions);
        $rows = $sql->select(
            sprintf('SELECT * FROM %s %s', self::TABLE_NAME, $where),
            $params
        );
        return array_map([MySQLOrderMapper::class, 'toDomain'], $rows);
    }

    public function create(Order $order): void
    {
        $sql = new SQL();
        $data = MySQLOrderMapper::toArray($order);
        $sql->insert(self::TABLE_NAME, $data);
    }

    public function update(Order $order): void
    {
        $sql = new SQL();
        $data = MySQLOrderMapper::toArray($order);
        $sql->update(self::TABLE_NAME, $data, ['id' => $order->getId()]);
    }

    public function delete(string $id): void
    {
        $sql = new SQL();
        $sql->delete(self::TABLE_NAME, ['id' => $id]);
    }
}
