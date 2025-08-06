<?php

namespace src\core\services;

interface ContextProviderServiceInterface
{
    /**
     * Retorna variáveis globais para o contexto informado.
     * @param string $key
     * @param mixed $context
     * @return array
     */
    public function getGlobals(string $key, $context): array;
}
