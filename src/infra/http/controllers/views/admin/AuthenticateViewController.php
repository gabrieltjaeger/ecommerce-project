<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\presentation\AdminPage;


class AuthenticateViewController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $page = new AdminPage([], 'login.html.twig');
    $response->getBody()->write($page->fetch());
    return $response->withHeader('Content-Type', 'text/html');
  }
}