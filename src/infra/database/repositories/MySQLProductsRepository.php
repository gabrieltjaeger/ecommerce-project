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
        return array_map([MySQLProductMapper::class, 'toDomain'], $rows);
    }

    public function create(Product $product): void
    {
        $sql = new SQL();
        $conn = $sql->getConnection();

        $stmt = $conn->prepare('CALL create_product(?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $product->getProduct(),
            $this->nullIfEmpty($product->getPrice()),
            $this->nullIfEmpty($product->getWidth()),
            $this->nullIfEmpty($product->getHeight()),
            $this->nullIfEmpty($product->getLength()),
            $this->nullIfEmpty($product->getWeight()),
            $product->getUrl(),
        ]);
    }

    public function update(Product $product): void
    {
        if (!$product->getId()) {
            throw new \InvalidArgumentException('Product must have a valid ID to be updated.');
        }

        $sql = new SQL();
        $conn = $sql->getConnection();

        $stmt = $conn->prepare('CALL update_product(?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            (int)$product->getId(),
            $product->getProduct(),
            $this->nullIfEmpty($product->getPrice()),
            $this->nullIfEmpty($product->getWidth()),
            $this->nullIfEmpty($product->getHeight()),
            $this->nullIfEmpty($product->getLength()),
            $this->nullIfEmpty($product->getWeight()),
            $product->getUrl(),
        ]);
    }

    public function delete(string $id): void
    {
        $sql = new SQL();
        $conn = $sql->getConnection();

        $stmt = $conn->prepare('CALL delete_product(?)');
        $stmt->execute([(int)$id]);
    }

    private function nullIfEmpty(?string $value): ?string
    {
        return $value === '' ? null : $value;
    }
}