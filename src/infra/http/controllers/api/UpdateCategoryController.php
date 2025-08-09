<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateCategoryController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $data = $request->getParsedBody();
    $id = (int) ($args['id'] ?? 0);
    $category = $data['category'] ?? null;

    if (!$category) {
      $response->getBody()->write(json_encode(['error' => 'Todos os campos são obrigatórios.']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $updateCategoryUseCase = $this->container->get('updateCategoryUseCase');

    try {
      $updateCategoryUseCase->execute($id, $category);
      header('Location: /admin/categories/' . $id);
      exit;
    } catch (\Exception $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
  }
}
?>
