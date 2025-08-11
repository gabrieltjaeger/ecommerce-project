<?php
namespace src\infra\http\controllers\views\admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class CategoryProductsViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $id = (int) ($args['id'] ?? 0);

    $useCase = $this->container->get('listCategoryProductsUseCase');
    try {
      $result = $useCase->execute($id);
    } catch (\InvalidArgumentException $e) {
      $response->getBody()->write('Category not found');
      return $response->withStatus(404);
    }

    $html = $this->renderView(
      'admin/categories-products.html.twig',
      [
        'category' => $result['category'],
        'inCategoryProducts' => $result['inCategory'],
        'uncategorizedProducts' => $result['uncategorized'],
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
