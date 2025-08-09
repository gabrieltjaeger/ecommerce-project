<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class UpdateProductViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $id = (int) ($args['id'] ?? 0);

    $fetchProductUseCase = $this->container->get('fetchProductUseCase');
    $product = $fetchProductUseCase->execute($id);

    if (!$product) {
      $response->getBody()->write('Product not found');
      return $response->withStatus(404);
    }

    $html = $this->renderView(
      'admin/products-update.html.twig',
      [
        'product' => $product,
        'currentPage' => 'products'
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
