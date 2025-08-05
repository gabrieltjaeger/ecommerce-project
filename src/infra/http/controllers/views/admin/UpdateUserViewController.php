<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\presentation\AdminPage;


class UpdateUserViewController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $id = (int) ($args['id'] ?? null);

    $fetchUserUseCase = $this->container->get('fetchUserUseCase');
    $user = $fetchUserUseCase->execute($id);

    if (!$user) {
      $response->getBody()->write('User not found');
      return $response->withStatus(404);
    }

    $page = new AdminPage(
      data: [
        'user' => $user,
        'currentPage' => 'users'
      ],
      template: 'users-update.html.twig',
      contexts: [
        'auth' => $this->container->get('authContext')
      ]
    );

    $response->getBody()->write($page->fetch());
    return $response->withHeader('Content-Type', 'text/html');
  }

}