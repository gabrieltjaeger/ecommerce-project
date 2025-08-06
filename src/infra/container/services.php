<?php

use src\infra\services\SessionService;
use src\infra\services\CookieService;
use src\infra\services\EncrypterService;
use src\infra\services\TwigTemplateRendererService;
use src\infra\services\ViewContextProviderService;

return [
  "cookieService" => function ($container) {
    return new CookieService();
  },
  "sessionService" => function ($container) {
    return new SessionService(
      $container->get('sessionsRepository'),
      $container->get('cookieService'),
      $container->get('usersRepository')
    );
  },
  "encrypterService" => function ($container) {
    return new EncrypterService();
  },
  "contextProviderService" => function ($container) {
    return new ViewContextProviderService();
  },
  "templateRendererService" => function ($container) {
    return new TwigTemplateRendererService(

      dirname(__DIR__, 2) . "/presentation/views",
      "/assets/app/",
      $container->get('contextProviderService')
    );
  },
];
