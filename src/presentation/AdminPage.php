<?php

namespace src\presentation;

use src\presentation\Page;



class AdminPage extends Page
{
  /**
   * @param array $data
   * @param string $template
   * @param string $templates_path
   * @param string $assets_path
   * @param array $contexts
   */
  public function __construct(
    $data = [],
    $template = '',
    $templates_path = "/presentation/views/admin",
    $assets_path = "/assets/admin/",
    $contexts = []
  ) {
    $defaultPages = [
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

    if (!isset($data['pages'])) {
      $data['pages'] = $defaultPages;
    }

    parent::__construct($data, $template, $templates_path, $assets_path, $contexts);
  }
}

?>