<?php

namespace src\infra\http\controllers\api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutController
{

  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    return $this->logout($request, $response, $args);
  }

  public function logout(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $sessionId = $_COOKIE['SESSION_ID'] ?? null;
    if ($sessionId) {
      $sessionsRepository = $this->container->get('sessionsRepository');
      $sessionsRepository->delete($sessionId);
    }
    setcookie('SESSION_ID', '', [
      'expires' => time() - 3600,
      'path' => '/',
      'httponly' => true,
      'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
      'samesite' => 'Strict',
    ]);
    $response->getBody()->write(json_encode(['message' => 'Logout realizado com sucesso.']));

    return $response->withStatus(302)->withHeader('Location', '/admin/login');
  }
}

?>