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

    var_dump($users); // Debugging line, can be removed later

    $usersView = array_map(function ($user) {
      return [
        'id' => $user->getId(),
        'name' => $user->getPerson() ? $user->getPerson()->getName() : '',
        'email' => $user->getPerson() ? $user->getPerson()->getEmail() : '',
        'login' => $user->getLogin(),
        'isAdmin' => $user->getIsAdmin(),
      ];
    }, $users);



    $page = new AdminPage([
      'users' => $usersView
    ], 'users.html.twig');

    $response->getBody()->write($page->fetch());
    return $response->withHeader('Content-Type', 'text/html');
  }
}
