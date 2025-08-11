<?php

use PHPUnit\Framework\TestCase;
use Slim\Factory\AppFactory;

class AdminMiddlewareTest extends TestCase
{
    public function test_admin_without_session_redirects_to_login(): void
    {
        $container = require __DIR__ . '/../../../src/infra/container/index.php';
        AppFactory::setContainer($container);
        $app = AppFactory::create();
        $app->addRoutingMiddleware();
        (require __DIR__ . '/../../../src/infra/http/routes/views/index.php')($app);

        $request = (new \Slim\Psr7\Factory\ServerRequestFactory())->createServerRequest('GET', '/admin');
        $response = $app->handle($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('/admin/login', $response->getHeaderLine('Location'));
    }
}
