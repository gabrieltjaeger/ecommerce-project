<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateUserController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
  $data = $request->getParsedBody();
  $userId = (int) ($args['id'] ?? 0);
  $name = $data['name'] ?? '';
  $email = $data['email'] ?? '';
  $phone = $data['phone'] ?? '';
  $login = $data['login'] ?? '';
  $password = $data['password'] ?? '';
  // Checkbox: se não enviado, é false
  $isAdmin = isset($data['is_admin']) && ($data['is_admin'] === '1' || $data['is_admin'] === 'on' || $data['is_admin'] === 1);

    $updateUserUseCase = $this->container->get('updateUserUseCase');

    try {
      $updateUserUseCase->execute(
        $userId,
        $name,
        $email,
        $phone,
        $login,
        $password,
        $isAdmin
      );

      header('Location: /admin/users/' . $userId);
      exit;
    } catch (\InvalidArgumentException $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
  }
}

?>