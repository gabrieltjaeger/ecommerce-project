<?php

use PHPUnit\Framework\TestCase;
use Slim\Factory\AppFactory;

class AuthenticateRouteTest extends TestCase
{
    public function test_missing_credentials_returns_400(): void
    {
        $container = require __DIR__ . '/../../../src/infra/container/index.php';
        AppFactory::setContainer($container);
        $app = AppFactory::create();
        $app->addRoutingMiddleware();
        (require __DIR__ . '/../../../src/infra/http/routes/api/index.php')($app);

        $request = (new \Slim\Psr7\Factory\ServerRequestFactory())->createServerRequest('POST', '/admin/login');
        $request = $request->withParsedBody([]);
        $response = $app->handle($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
    }
}
