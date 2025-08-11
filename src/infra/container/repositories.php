<?php
use src\infra\database\repositories\MySQLAddressesRepository;
use src\infra\database\repositories\MySQLCartsRepository;
use src\infra\database\repositories\MySQLCategoriesRepository;
use src\infra\database\repositories\MySQLOrdersRepository;
use src\infra\database\repositories\MySQLPersonsRepository;
use src\infra\database\repositories\MySQLProductsRepository;
use src\infra\database\repositories\MySQLSessionsRepository;
use src\infra\database\repositories\MySQLUsersRepository;
use src\infra\database\repositories\MySQLProductsCategoriesRepository;

return [
  'addressesRepository' => function () {
    return new MySQLAddressesRepository();
  },
  'cartsRepository' => function () {
    return new MySQLCartsRepository();
  },
  'categoriesRepository' => function () {
    return new MySQLCategoriesRepository();
  },
  'ordersRepository' => function () {
    return new MySQLOrdersRepository();
  },
  'personsRepository' => function () {
    return new MySQLPersonsRepository();
  },
  'productsRepository' => function () {
    return new MySQLProductsRepository();
  },
  'productsCategoriesRepository' => function () {
    return new MySQLProductsCategoriesRepository();
  },
  'sessionsRepository' => function () {
    return new MySQLSessionsRepository();
  },
  'usersRepository' => function () {
    return new MySQLUsersRepository();
  },
];
