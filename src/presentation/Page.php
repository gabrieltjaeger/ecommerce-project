<?php

namespace src\presentation;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Page
{
  private Environment $twig;
  private array $data = [];
  private string $template;
  private array $contexts = [];

  /**
   * @param array $contexts Array associativo de contextos, ex: ['auth' => AuthContextInterface, ...]
   */
  public function __construct(
    array $data = [],
    string $template = '',
    string $templates_path = "/presentation/views",
    string $assets_path = "/assets/app/",
    array $contexts = []
  ) {
    $this->data = $data;
    $this->template = $template;
    $this->contexts = $contexts;

    $viewsPath = dirname(__DIR__) . $templates_path;
    $cachePath = dirname(__DIR__) . '/presentation/views-cache';
    $isProd = getenv('APP_ENV') === 'production';

    $loader = new FilesystemLoader($viewsPath);
    $this->twig = new Environment($loader, [
      'cache' => $isProd ? $cachePath : false,
      'auto_reload' => !$isProd,
      'debug' => !$isProd,
    ]);
    $this->twig->addFunction(new TwigFunction('asset', function ($path) use ($assets_path) {
      return $assets_path . ltrim($path, '/');
    }));

    // Injeção de variáveis globais do Twig a partir dos contextos fornecidos
    if (isset($this->contexts['auth'])) {
      $authUser = $this->contexts['auth']->getAuthenticatedUser();
      $this->twig->addGlobal('auth_user', $authUser);
    }
    // Adicione outros contextos conforme necessário, ex:
    // if (isset($this->contexts['cart'])) { ... }
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
