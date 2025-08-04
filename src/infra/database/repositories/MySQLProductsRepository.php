<?php
namespace src\infra\database\repositories;

use src\core\repositories\ProductsRepositoryInterface;
use src\core\repositories\requests\ProductSearchRequest;
use src\core\entities\Product;
use src\infra\database\mappers\MySQLProductMapper;
use src\infra\database\SQL;

class MySQLProductsRepository implements ProductsRepositoryInterface
{
    public const TABLE_NAME = 'products';

    public function find(ProductSearchRequest $request): ?Product
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'product' => $request->name ?? $request->product ?? null,
            'category_id' => $request->category_id ?? null,
            'price' => $request->price ?? null,
            'created_at' => $request->created_at ?? null,
            'updated_at' => $request->updated_at ?? null,
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
    return MySQLProductMapper::toDomain($row);
    }

    public function list(ProductSearchRequest $request): array
    {
        $sql = new SQL();
        $conditions = [
            'id' => $request->id,
            'product' => $request->name ?? $request->product ?? null,
            'category_id' => $request->category_id ?? null,
            'price' => $request->price ?? null,
            'created_at' => $request->created_at ?? null,
            'updated_at' => $request->updated_at ?? null,
        ];
        [$where, $params] = SQL::buildWhereClause($conditions);
        $rows = $sql->select(
            sprintf('SELECT * FROM %s %s', self::TABLE_NAME, $where),
            $params
        );
    return array_map([MySQLProductMapper::class, 'fromArray'], $rows);
    }

    public function create(Product $product): void
    {
        $sql = new SQL();
        $data = MySQLProductMapper::toArray($product);
        $sql->insert(self::TABLE_NAME, $data);
    }

    public function update(Product $product): void
    {
        $sql = new SQL();
        $data = MySQLProductMapper::toArray($product);
        $sql->update(self::TABLE_NAME, $data, ['id' => $product->getId()]);
    }

    public function delete(string $id): void
    {
        $sql = new SQL();
        $sql->delete(self::TABLE_NAME, ['id' => $id]);
    }
}
