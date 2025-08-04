<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateUserController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $data = $request->getParsedBody();
    $name = $data['name'] ?? null;
    $login = $data['login'] ?? null;
    $phone = $data['phone'] ?? null;
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;
    $isAdmin = (bool) ($data['is_admin'] ?? false);

    if (!$name || !$login || !$password || !$email || !$phone) {
      $response->getBody()->write(json_encode(['error' => 'Todos os campos são obrigatórios.']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $createUserUseCase = $this->container->get('createUserUseCase');

    try {
      $result = $createUserUseCase->execute(
        $name,
        $login,
        $phone,
        $email,
        $password,
        $isAdmin
      );

      header('Location: /admin/users' . $result->getId());
      exit;
    } catch (\Exception $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
  }
}

?>

