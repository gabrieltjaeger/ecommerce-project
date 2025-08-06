<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class UpdateUserViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $id = (int) ($args['id'] ?? null);

    $fetchUserUseCase = $this->container->get('fetchUserUseCase');

    $user = $fetchUserUseCase->execute($id);

    if (!$user) {
      $response->getBody()->write('User not found');
      return $response->withStatus(404);
    }

    $html = $this->renderView(
      'admin/users-update.html.twig',
      [
        'user' => $user,
        'currentPage' => 'users'
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