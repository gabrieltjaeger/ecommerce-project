<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateProductController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $data = $request->getParsedBody();
    $product = $data['product'] ?? null;
    $price = $data['price'] ?? null;
    $width = $data['width'] ?? null;
    $height = $data['height'] ?? null;
    $length = $data['length'] ?? null;
    $weight = $data['weight'] ?? null;
    $url = $data['url'] ?? null;

    if (!$product || !$price || !$width || !$height || !$length || !$weight || !$url) {
      $response->getBody()->write(json_encode(['error' => 'Todos os campos são obrigatórios.']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $createProductUseCase = $this->container->get('createProductUseCase');

    try {
      $createProductUseCase->execute($product, $price, $width, $height, $length, $weight, $url);
      header('Location: /admin/products');
      exit;
    } catch (\Exception $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
  }
}
?>
