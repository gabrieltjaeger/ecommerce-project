<?php
namespace src\infra\contexts;

use src\core\contexts\AuthContextInterface;
use src\core\entities\User;
use src\core\services\SessionServiceInterface;
use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;

class AdminPagesContext
{
  public function __construct(){}

  public function getAdminPages(): array
  {
    return [
      [
        'label' => 'Dashboard',
        'route' => '/admin',
        'icon' => 'fas fa-tachometer-alt',
        'key' => 'dashboard',
      ],
      [
        'label' => 'Usuários',
        'route' => '/admin/users',
        'icon' => 'fas fa-users',
        'key' => 'users',
      ],
      [
        'label' => 'Produtos',
        'route' => '/admin/products',
        'icon' => 'fas fa-box',
        'key' => 'products',
      ],
      [
        'label' => 'Categorias',
        'route' => '/admin/categories',
        'icon' => 'fas fa-tags',
        'key' => 'categories',
      ],
      [
        'label' => 'Pedidos',
        'route' => '/admin/orders',
        'icon' => 'fas fa-shopping-cart',
        'key' => 'orders',
      ],
    ];
  }
}
