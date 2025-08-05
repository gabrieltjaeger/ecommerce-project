<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteUserController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $userId = $request->getAttribute('id');

    if (!$userId) {
      $response->getBody()->write(json_encode(['error' => 'User ID is required.']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $deleteUserUseCase = $this->container->get('deleteUserUseCase');

    try {
      $deleteUserUseCase->execute($userId);

      header('Location: /admin/users');
      exit;
    } catch (\InvalidArgumentException $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
  }
}

?>