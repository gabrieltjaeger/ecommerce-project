<?php

namespace src\infra\http\controllers;

use Psr\Container\ContainerInterface;

abstract class ViewController
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function renderView(string $template, array $data = [], array $contexts = []): string
    {
        $viewRenderer = $this->container->get('templateRendererService');
        return $viewRenderer->renderWithContext($template, $data, $contexts);
    }
}
