<?php
namespace src\core\repositories;

use src\core\entities\Category;
use src\core\repositories\requests\CategorySearchRequest;

interface CategoriesRepositoryInterface
{
  public function find(CategorySearchRequest $request): ?Category;
  /**
   * @return Category[]
   */
  public function list(CategorySearchRequest $request): array;
  public function create(Category $category): void;
  public function update(Category $category): void;
  public function delete(string $id): void;
}
