<?php

namespace src\presentation;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Page
{
  private Environment $twig;
  private array $data = [];
  private string $template;

  public function __construct(array $data = [], string $template = 'header.html.twig')
  {
    $this->data = $data;
    $this->template = $template;

    $viewsPath = dirname(__DIR__) . '/presentation/views';
    $cachePath = dirname(__DIR__) . '/presentation/views-cache';
    $isProd = getenv('APP_ENV') === 'production';

    $loader = new FilesystemLoader($viewsPath);
    $this->twig = new Environment($loader, [
      'cache' => $isProd ? $cachePath : false,
      'auto_reload' => !$isProd,
      'debug' => !$isProd,
    ]);
  }

  public function render(): void
  {
    echo $this->twig->render($this->template, $this->data);
  }

  public function fetch(): string
  {
    return $this->twig->render($this->template, $this->data);
  }

  public function setData(array $data): void
  {
    $this->data = $data;
  }

  public function getData(): array
  {
    return $this->data;
  }
}
