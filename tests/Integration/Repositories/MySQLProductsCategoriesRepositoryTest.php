<?php

use PHPUnit\Framework\TestCase;
use src\infra\database\SQL;
use src\infra\database\repositories\MySQLProductsCategoriesRepository;

class MySQLProductsCategoriesRepositoryTest extends TestCase
{
    private SQL $sql;
    private string $categoryId;
    private string $productId;

    protected function setUp(): void
    {
        $this->sql = new SQL();
        // Ensure minimal fixtures committed for FK checks across connections
        $this->sql->insert('categories', ['category' => 'TestCat_PCRepo']);
        $this->sql->insert('products', [
            'product' => 'TestProduct',
            'price' => 10.00,
            'width' => 1,
            'height' => 1,
            'length' => 1,
            'weight' => 1,
            'url' => 'http://example.com'
        ]);
        $this->categoryId = $this->getLastInsertId('categories');
        $this->productId = $this->getLastInsertId('products');
    }

    protected function tearDown(): void
    {
        // cleanup created relations and fixtures
        $this->sql->delete('products_categories', [
            'category_id' => (int)$this->categoryId,
            'product_id' => (int)$this->productId,
        ]);
        $this->sql->delete('products', ['id' => (int)$this->productId]);
        $this->sql->delete('categories', ['id' => (int)$this->categoryId]);
    }

    private function getLastInsertId(string $table): string
    {
        $row = $this->sql->select("SELECT id FROM $table ORDER BY id DESC LIMIT 1")[0] ?? null;
        $this->assertNotNull($row, "Fixture missing for $table");
        return (string)$row['id'];
    }

    public function test_add_and_list_by_category(): void
    {
    $categoryId = $this->categoryId;
    $productId = $this->productId;

        $repo = new MySQLProductsCategoriesRepository();
        $repo->add($categoryId, $productId);

        $products = $repo->listByCategory($categoryId);
        $this->assertCount(1, $products);
        $this->assertSame($productId, $products[0]->getId());
    }

    public function test_add_is_idempotent_with_unique_constraint(): void
    {
    $categoryId = $this->categoryId;
    $productId = $this->productId;

        $repo = new MySQLProductsCategoriesRepository();
        $repo->add($categoryId, $productId);
        // Should not throw or duplicate due to INSERT IGNORE + unique key
        $repo->add($categoryId, $productId);

        $rows = $this->sql->select(
            'SELECT COUNT(*) AS c FROM products_categories WHERE category_id = :c AND product_id = :p',
            [':c' => $categoryId, ':p' => $productId]
        );
        $this->assertSame('1', (string)$rows[0]['c']);
    }

    public function test_remove_deletes_relation(): void
    {
    $categoryId = $this->categoryId;
    $productId = $this->productId;

        $repo = new MySQLProductsCategoriesRepository();
        $repo->add($categoryId, $productId);
        $repo->remove($categoryId, $productId);

        $rows = $this->sql->select(
            'SELECT COUNT(*) AS c FROM products_categories WHERE category_id = :c AND product_id = :p',
            [':c' => $categoryId, ':p' => $productId]
        );
        $this->assertSame('0', (string)$rows[0]['c']);
    }

    public function test_list_uncategorized_returns_product_when_no_relation(): void
    {
        // ensure there is no relation
        $this->sql->delete('products_categories', [
            'category_id' => (int)$this->categoryId,
            'product_id' => (int)$this->productId,
        ]);

        $repo = new MySQLProductsCategoriesRepository();
        $list = $repo->listUncategorized();
        $ids = array_map(fn($p) => $p->getId(), $list);
        $this->assertContains($this->productId, $ids);
    }
}
