<?php
namespace src\infra\database\repositories;

use src\core\repositories\ProductsCategoriesRepositoryInterface;
use src\infra\database\SQL;
use src\infra\database\mappers\MySQLProductMapper;
use src\core\entities\Product;

class MySQLProductsCategoriesRepository implements ProductsCategoriesRepositoryInterface
{
    public const TABLE_NAME = 'products_categories';

    /**
     * @return Product[]
     */
    public function listByCategory(string $categoryId): array
    {
        $sql = new SQL();
        $rows = $sql->select(
            'SELECT p.* 
               FROM products p
               INNER JOIN products_categories pc ON pc.product_id = p.id
              WHERE pc.category_id = :category_id',
            [':category_id' => $categoryId]
        );
        return array_map([MySQLProductMapper::class, 'toDomain'], $rows);
    }

    /**
     * @return Product[]
     */
    public function listUncategorized(): array
    {
        $sql = new SQL();
        $rows = $sql->select(
            'SELECT p.*
               FROM products p
               LEFT JOIN products_categories pc ON pc.product_id = p.id
              WHERE pc.product_id IS NULL'
        );
        return array_map([MySQLProductMapper::class, 'toDomain'], $rows);
    }

    public function add(string $categoryId, string $productId): void
    {
        $sql = new SQL();
        $conn = $sql->getConnection();
        $stmt = $conn->prepare(
            'INSERT IGNORE INTO products_categories (category_id, product_id) VALUES (?, ?)'
        );
        $stmt->execute([$categoryId, $productId]);
    }

    public function remove(string $categoryId, string $productId): void
    {
        $sql = new SQL();
        $sql->delete(self::TABLE_NAME, [
            'category_id' => $categoryId,
            'product_id' => $productId
        ]);
    }
}
?>
