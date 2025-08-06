<?php

namespace src\infra\http\controllers\views\admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\infra\http\controllers\ViewController;

class AuthenticateViewController extends ViewController
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
  {
    $authContext = $this->container->get('authContext');
    $html = $this->renderView(
      'admin/login.html.twig',
      [],
      ['auth' => $authContext]
    );
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
  }
}