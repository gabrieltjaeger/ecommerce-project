<?php

namespace src\infra\services;

use src\core\services\ContextProviderServiceInterface;

class ViewContextProviderService implements ContextProviderServiceInterface
{
  public function getGlobals(string $key, $context): array
  {
    switch ($key) {
      case 'auth':
        return ['auth_user' => $context->getAuthenticatedUser()];
      case 'adminPages':
        return ['adminPages' => $context->getAdminPages()];
      default:
        return [];
    }
  }
}
