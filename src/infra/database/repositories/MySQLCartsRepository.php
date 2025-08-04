<?php
namespace src\infra\database\repositories;

use src\core\repositories\CartsRepositoryInterface;
use src\core\entities\Cart;
use src\core\repositories\requests\CartSearchRequest;
use src\infra\database\mappers\MySQLCartMapper;
use src\infra\database\SQL;

class MySQLCartsRepository implements CartsRepositoryInterface
{
    public const TABLE_NAME = 'carts';

    public function find(CartSearchRequest $request): ?Cart
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
        return MySQLCartMapper::toDomain($row);
    }

    public function list(CartSearchRequest $request): array
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
        return array_map([MySQLCartMapper::class, 'fromArray'], $rows);
    }

    public function create(Cart $cart): void
    {
        $sql = new SQL();
        $data = MySQLCartMapper::toArray($cart);
        $sql->insert(self::TABLE_NAME, $data);
    }

    public function update(Cart $cart): void
    {
        $sql = new SQL();
        $data = MySQLCartMapper::toArray($cart);
        $sql->update(self::TABLE_NAME, $data, ['id' => $cart->getId()]);
    }

    public function delete(string $id): void
    {
        $sql = new SQL();
        $sql->delete(self::TABLE_NAME, ['id' => $id]);
    }
}
