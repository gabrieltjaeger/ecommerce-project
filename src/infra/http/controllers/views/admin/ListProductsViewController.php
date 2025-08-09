<?php
namespace src\infra\http\controllers\views;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class ListProductsViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $listProductsUseCase = $this->container->get('listProductsUseCase');
    $products = $listProductsUseCase->execute();

    $html = $this->renderView(
      'admin/products.html.twig',
      [
        'products' => $products,
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
