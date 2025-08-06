<?php

namespace src\core\services;

interface TemplateRendererServiceInterface
{
    /**
     * Renderiza um template com os dados fornecidos.
     * @param string $template Nome do template
     * @param array $data Dados para o template
     * @return string HTML renderizado
     */
    public function render(string $template, array $data = []): string;
}
