<?php
namespace src\infra\database\repositories;

use src\core\repositories\CategoriesRepositoryInterface;
use src\core\entities\Category;
use src\core\repositories\requests\CategorySearchRequest;
use src\infra\database\mappers\MySQLCategoryMapper;
use src\infra\database\SQL;

class MySQLCategoriesRepository implements CategoriesRepositoryInterface
{
  public const TABLE_NAME = 'categories';

  public function find(CategorySearchRequest $request): ?Category
  {
    $sql = new SQL();
    $conditions = [
      'id' => $request->id,
      'category' => $request->category,
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
    return MySQLCategoryMapper::toDomain($row);
  }

  public function list(CategorySearchRequest $request): array
  {
    $sql = new SQL();
    $conditions = [
      'id' => $request->id,
      'category' => $request->category,
      'created_at' => $request->created_at,
      'updated_at' => $request->updated_at,
    ];
    [$where, $params] = SQL::buildWhereClause($conditions);
    $rows = $sql->select(
      sprintf('SELECT * FROM %s %s', self::TABLE_NAME, $where),
      $params
    );
    return array_map([MySQLCategoryMapper::class, 'fromArray'], $rows);
  }

  public function create(Category $category): void
  {
    $sql = new SQL();
    $data = MySQLCategoryMapper::toArray($category);
    $sql->insert(self::TABLE_NAME, $data);
  }

  public function update(Category $category): void
  {
    $sql = new SQL();
    $data = MySQLCategoryMapper::toArray($category);
    $sql->update(self::TABLE_NAME, $data, ['id' => $category->getId()]);
  }

  public function delete(string $id): void
  {
    $sql = new SQL();
    $sql->delete(self::TABLE_NAME, ['id' => $id]);
  }
}
