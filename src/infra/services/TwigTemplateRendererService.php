<?php

namespace src\infra\services;

use src\core\services\ContextProviderServiceInterface;
use src\core\services\TemplateRendererServiceInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigTemplateRendererService implements TemplateRendererServiceInterface
{
  private Environment $twig;
  private string $viewsPath;
  private string $assetsPath;
  private ContextProviderServiceInterface $contextProvider;


  public function __construct(
    string $viewsPath,
    string $assetsPath,
    ContextProviderServiceInterface $contextProvider
  ) {
    $this->viewsPath = $viewsPath;
    $this->assetsPath = $assetsPath;
    $this->contextProvider = $contextProvider;

    $cachePath = dirname(__DIR__, 2) . '/presentation/views-cache';
    $isProd = getenv('APP_ENV') === 'production';

    $loader = new FilesystemLoader($this->viewsPath);
    $this->twig = new Environment($loader, [
      'cache' => $isProd ? $cachePath : false,
      'auto_reload' => !$isProd,
      'debug' => !$isProd,
    ]);

    $this->twig->addFunction(new TwigFunction('asset', function ($path) use ($assetsPath) {
      return $assetsPath . ltrim($path, '/');
    }));
  }

  public function render(string $template, array $data = []): string
  {
    return $this->twig->render($template, $data);
  }

  public function renderWithContext(string $template, array $data = [], array $contexts = []): string
  {
    foreach ($contexts as $key => $context) {
      $data = array_merge($data, $this->contextProvider->getGlobals($key, $context));
    }

    return $this->render($template, $data);
  }
}