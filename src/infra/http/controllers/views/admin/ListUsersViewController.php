<?php
namespace src\infra\http\controllers\views\admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class ListUsersViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $page = (int) ($args['page'] ?? null);
    $name = (string) ($args['name'] ?? null);

    $listUsersUseCase = $this->container->get('listUsersUseCase');
    $users = $listUsersUseCase->execute($page, $name);

    $html = $this->renderView(
      'admin/users.html.twig',
      [
        'users' => $users,
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
