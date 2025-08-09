<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCategoryController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $categoryId = $request->getAttribute('id');

    if (!$categoryId) {
      $response->getBody()->write(json_encode(['error' => 'Category ID is required.']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $deleteCategoryUseCase = $this->container->get('deleteCategoryUseCase');

    try {
      $deleteCategoryUseCase->execute($categoryId);
      header('Location: /admin/categories');
      exit;
    } catch (\Exception $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
  }
}
?>
