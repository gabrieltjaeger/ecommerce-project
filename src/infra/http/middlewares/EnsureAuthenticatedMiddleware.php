<?php

namespace src\infra\http\middlewares;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

// TO-DO: Change to use dependencies injection for the repository

use src\infra\database\repositories\MySQLUsersRepository;
use src\infra\database\repositories\MySQLSessionsRepository;
use src\core\repositories\requests\SessionSearchRequest;
use src\core\repositories\requests\UserSearchRequest;

class EnsureAuthenticatedMiddleware
{
  public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
  {
    // Valida sessão pelo cookie SESSION_ID
    if (!isset($_COOKIE['SESSION_ID'])) {
      $response = new Response();
      $response->getBody()->write(json_encode(['error' => 'Unauthorized: No session cookie']));
      return $response->withStatus(401)
        ->withHeader('Content-Type', 'application/json');
    }

    $sessionId = $_COOKIE['SESSION_ID'];
    $sessionsRepository = new MySQLSessionsRepository();
    $session = $sessionsRepository->find(new SessionSearchRequest(id: $sessionId));

    if (!$session) {
      $response = new Response();
      $response->getBody()->write(json_encode(['error' => 'Unauthorized: Invalid session']));
      return $response->withStatus(401)
        ->withHeader('Content-Type', 'application/json');
    }

    // Valida IP e user-agent para maior segurança
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
    if ($session->getIpAddress() !== $ip || $session->getUserAgent() !== $agent) {
      $response = new Response();
      $response->getBody()->write(json_encode(['error' => 'Unauthorized: Session mismatch']));
      return $response->withStatus(401)
        ->withHeader('Content-Type', 'application/json');
    }

    $usersRepository = new MySQLUsersRepository();
    $user = $usersRepository->find(new UserSearchRequest(id: $session->getUserId()));

    if (!$user) {
      $response = new Response();
      $response->getBody()->write(json_encode(['error' => 'User not found']));
      return $response->withStatus(404)
        ->withHeader('Content-Type', 'application/json');
    }

    if (!$user->getIsAdmin()) {
      $response = new Response();
      $response->getBody()->write(json_encode(['error' => 'Forbidden']));
      return $response->withStatus(403)
        ->withHeader('Content-Type', 'application/json');
    }

    // Sessão e usuário válidos, segue para a rota
    return $handler->handle($request);
  }
}
?>