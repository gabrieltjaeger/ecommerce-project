<?php
// Exemplo para serviços (adicione aqui quando necessário)

use src\core\services\SessionServiceInterface;
use src\infra\services\SessionService;
use src\core\repositories\SessionsRepositoryInterface;
use src\core\services\CookieServiceInterface;
use src\infra\services\CookieService;

return [
  "cookieService" => function ($container) {
    return new CookieService();
  },
  "sessionService" => function ($container) {
    return new SessionService(
      $container->get('sessionsRepository'),
      $container->get('cookieService')
    );
  },
];
