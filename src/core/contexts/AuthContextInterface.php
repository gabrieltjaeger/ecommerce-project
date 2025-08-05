<?php
namespace src\core\contexts;

use src\core\entities\User;

interface AuthContextInterface
{
    /**
     * Retorna o usuário autenticado na sessão atual, se houver.
     * @return User|null
     */
    public function getAuthenticatedUser(): ?User;
}
