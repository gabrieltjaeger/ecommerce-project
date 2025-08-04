<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\presentation\AdminPage;


class CreateUserViewController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $id = (int) ($args['id'] ?? null);

    $page = new AdminPage([], 'users-create.html.twig');

    $response->getBody()->write($page->fetch());
    return $response->withHeader('Content-Type', 'text/html');
  }

}