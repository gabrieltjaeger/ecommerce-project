<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\presentation\AdminPage;


class IndexViewController
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
  {
    $page = new AdminPage(
      data: [
        'currentPage' => 'dashboard'
      ],
      template: 'index.html.twig',
      contexts: [
        'auth' => $this->container->get('authContext')
      ]
    );
    $response->getBody()->write($page->fetch());
    return $response->withHeader('Content-Type', 'text/html');
  }
}