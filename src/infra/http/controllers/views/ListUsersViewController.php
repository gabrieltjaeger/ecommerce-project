<?php
namespace src\infra\http\controllers\views;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\presentation\AdminPage;

class ListUsersViewController
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

    $page = new AdminPage(
      data: [
        'users' => $users,
        'currentPage' => 'users'
      ],
      template: 'users.html.twig',
      contexts: [
        'auth' => $this->container->get('authContext')
      ]
    );

    $response->getBody()->write($page->fetch());
    return $response->withHeader('Content-Type', 'text/html');
  }
}
