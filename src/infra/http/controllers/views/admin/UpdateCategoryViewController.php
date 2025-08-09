<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class UpdateCategoryViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $id = (int) ($args['id'] ?? 0);

    $fetchCategoryUseCase = $this->container->get('fetchCategoryUseCase');
    $category = $fetchCategoryUseCase->execute($id);

    if (!$category) {
      $response->getBody()->write('Category not found');
      return $response->withStatus(404);
    }

    $html = $this->renderView(
      'admin/categories-update.html.twig',
      [
        'category' => $category,
        'currentPage' => 'categories'
      ],
      [
        'auth' => $this->container->get('authContext'),
        'adminPages' => $this->container->get('adminPagesContext')
      ]
    );
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
  }
}
?>
