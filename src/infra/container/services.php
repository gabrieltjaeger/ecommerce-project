<?php
// Exemplo para serviços (adicione aqui quando necessário)

use src\infra\services\SessionService;
use src\infra\services\CookieService;
use src\infra\services\EncrypterService;

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
  "encrypterService" => function ($container) {
    return new EncrypterService();
  },
];
