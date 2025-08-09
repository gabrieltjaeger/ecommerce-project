<?php
use src\core\use_cases\AuthenticateUseCase;
use src\core\use_cases\ListUsersUseCase;
use src\core\use_cases\FetchUserUseCase;
use src\core\use_cases\CreateUserUseCase;
use src\core\use_cases\UpdateUserUseCase;
use src\core\use_cases\DeleteUserUseCase;
use src\core\use_cases\ListCategoriesUseCase;
use src\core\use_cases\FetchCategoryUseCase;
use src\core\use_cases\CreateCategoryUseCase;
use src\core\use_cases\UpdateCategoryUseCase;
use src\core\use_cases\DeleteCategoryUseCase;
use src\core\use_cases\ListProductsUseCase;
use src\core\use_cases\FetchProductUseCase;
use src\core\use_cases\CreateProductUseCase;
use src\core\use_cases\UpdateProductUseCase;
use src\core\use_cases\DeleteProductUseCase;

return [
  'authenticateUseCase' => function ($c) {
    return new AuthenticateUseCase(
      $c->get('usersRepository'),
      $c->get('sessionService')
    );
  },
  'listUsersUseCase' => function ($c) {
    return new ListUsersUseCase(
      $c->get('usersRepository')
    );
  },
  'fetchUserUseCase' => function ($c) {
    return new FetchUserUseCase(
      $c->get('usersRepository')
    );
  },
  'createUserUseCase' => function ($c) {
    return new CreateUserUseCase(
      $c->get('usersRepository'),
      $c->get('personsRepository'),
      $c->get('encrypterService')
    );
  },
  'updateUserUseCase' => function ($c) {
    return new UpdateUserUseCase(
      $c->get('usersRepository'),
      $c->get('personsRepository'),
      $c->get('encrypterService')
    );
  },
  'deleteUserUseCase' => function ($c) {
    return new DeleteUserUseCase(
      $c->get('usersRepository'),
    );
  },
  'listCategoriesUseCase' => function ($c) {
    return new ListCategoriesUseCase(
      $c->get('categoriesRepository')
    );
  },
  'fetchCategoryUseCase' => function ($c) {
    return new FetchCategoryUseCase(
      $c->get('categoriesRepository')
    );
  },
  'createCategoryUseCase' => function ($c) {
    return new CreateCategoryUseCase(
      $c->get('categoriesRepository')
    );
  },
  'updateCategoryUseCase' => function ($c) {
    return new UpdateCategoryUseCase(
      $c->get('categoriesRepository')
    );
  },
  'deleteCategoryUseCase' => function ($c) {
    return new DeleteCategoryUseCase(
      $c->get('categoriesRepository'),
    );
  },
  'listProductsUseCase' => function ($c) {
    return new ListProductsUseCase(
      $c->get('productsRepository')
    );
  },
  'fetchProductUseCase' => function ($c) {
    return new FetchProductUseCase(
      $c->get('productsRepository')
    );
  },
  'createProductUseCase' => function ($c) {
    return new CreateProductUseCase(
      $c->get('productsRepository')
    );
  },
  'updateProductUseCase' => function ($c) {
    return new UpdateProductUseCase(
      $c->get('productsRepository')
    );
  },
  'deleteProductUseCase' => function ($c) {
    return new DeleteProductUseCase(
      $c->get('productsRepository'),
      $c->get('categoriesRepository')
    );
  }
];
