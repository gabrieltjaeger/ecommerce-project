<?php
namespace src\infra\http\controllers\views\admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class ListCategoriesViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $listCategoriesUseCase = $this->container->get('listCategoriesUseCase');
    $categories = $listCategoriesUseCase->execute();

    $html = $this->renderView(
      'admin/categories.html.twig',
      [
        'categories' => $categories,
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
