<?php
namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RemoveProductFromCategoryController
{
  public function __construct(private ContainerInterface $container) {}

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $categoryId = (int) ($args['id'] ?? 0);
    $productId = (int) ($args['productId'] ?? 0);

    $useCase = $this->container->get('removeProductFromCategoryUseCase');

    try {
      $useCase->execute($categoryId, $productId);
      header('Location: /admin/categories/' . $categoryId . '/products');
      exit;
    } catch (\Throwable $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
  }
}
?>
