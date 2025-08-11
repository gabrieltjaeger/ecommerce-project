<?php

use PHPUnit\Framework\TestCase;
use src\core\use_cases\AddProductToCategoryUseCase;
use src\core\repositories\CategoriesRepositoryInterface;
use src\core\repositories\ProductsRepositoryInterface;
use src\core\repositories\ProductsCategoriesRepositoryInterface;
use src\core\entities\Category;
use src\core\entities\Product;
use src\core\repositories\requests\CategorySearchRequest;
use src\core\repositories\requests\ProductSearchRequest;

class AddProductToCategoryUseCaseTest extends TestCase
{
    public function test_category_not_found_throws_exception(): void
    {
        $categories = $this->createMock(CategoriesRepositoryInterface::class);
        $products = $this->createMock(ProductsRepositoryInterface::class);
        $productsCats = $this->createMock(ProductsCategoriesRepositoryInterface::class);

        $categories->method('find')->willReturn(null);

        $uc = new AddProductToCategoryUseCase($categories, $products, $productsCats);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Category not found');
        $uc->execute(1, 2);
    }

    public function test_product_not_found_throws_exception(): void
    {
        $categories = $this->createMock(CategoriesRepositoryInterface::class);
        $products = $this->createMock(ProductsRepositoryInterface::class);
        $productsCats = $this->createMock(ProductsCategoriesRepositoryInterface::class);

        $categories->method('find')->willReturn(new Category(id: '1', category: 'Cat'));
        $products->method('find')->willReturn(null);

        $uc = new AddProductToCategoryUseCase($categories, $products, $productsCats);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Product not found');
        $uc->execute(1, 2);
    }

    public function test_success_calls_repository_add_once(): void
    {
        $categories = $this->createMock(CategoriesRepositoryInterface::class);
        $products = $this->createMock(ProductsRepositoryInterface::class);
        $productsCats = $this->createMock(ProductsCategoriesRepositoryInterface::class);

        $categories->method('find')->willReturn(new Category(id: '1', category: 'Cat'));
        $products->method('find')->willReturn(new Product(id: '2', product: 'P'));

        $productsCats->expects($this->once())
            ->method('add')
            ->with('1', '2');

        $uc = new AddProductToCategoryUseCase($categories, $products, $productsCats);
        $uc->execute(1, 2);
    }
}
