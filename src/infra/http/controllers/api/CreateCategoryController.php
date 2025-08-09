<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCategoryController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $data = $request->getParsedBody();
    $category = $data['category'] ?? null;

    if (!$category) {
      $response->getBody()->write(json_encode(['error' => 'Todos os campos são obrigatórios.']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $createCategoryUseCase = $this->container->get('createCategoryUseCase');

    try {
      $createCategoryUseCase->execute($category);
      header('Location: /admin/categories');
      exit;
    } catch (\Exception $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
  }
}
?>
