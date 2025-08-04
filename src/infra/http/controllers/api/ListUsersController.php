<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListUsersController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $page = (int) ($args['page'] ?? null);
    $name = (string) ($args['name'] ?? null);

    $listUsersUseCase = $this->container->get('listUsersUseCase');
    $users = $listUsersUseCase->execute($page, $name);

    $response->getBody()->write(json_encode($users));
    return $response->withHeader('Content-Type', 'application/json');
  }
}