<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticateController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $data = $request->getParsedBody();
    $login = $data['login'] ?? null;
    $senha = $data['password'] ?? null;

    if (!$login || !$senha) {
      $response->getBody()->write(json_encode(['error' => 'Login e senha são obrigatórios.']));
      return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $authUseCase = $this->container->get('authenticateUseCase');

    try {
      $result = $authUseCase->execute(
        $login,
        $senha,
        $_SERVER['REMOTE_ADDR'] ?? null,
        $_SERVER['HTTP_USER_AGENT'] ?? null
      );
      $user = $result['user'];
      $session = $result['session'];


      header('Location: /admin');
      exit;
    } catch (\Exception $e) {
      $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
      return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }
  }
}