<?php

use PHPUnit\Framework\TestCase;
use Slim\Factory\AppFactory;
use DI\Container;
use src\core\entities\User;
use src\core\entities\Session;
use src\infra\database\SQL;

class AuthLoginFeatureTest extends TestCase
{
    public function test_login_success_redirects_to_admin(): void
    {
        // Cria um container e sobrescreve o authenticateUseCase com um fake
        $baseContainer = require __DIR__ . '/../../src/infra/container/index.php';
        $container = new Container();
        // Copia definições existentes
        foreach (['contexts','repositories','services','usecases'] as $key) {
            // nada a fazer aqui, já carregado pelo index.php do projeto
        }
        // Clona registros do baseContainer para manter wiring existente
        foreach (['authenticateUseCase'] as $key) {
            // Vamos substituir apenas authenticateUseCase
        }
        // Fake use case que sempre autentica
        $fakeUseCase = new class {
            public function execute(string $login, string $password, ?string $ip = null, ?string $ua = null): array
            {
                $user = new User(id: '1', login: $login, password_hash: password_hash($password, PASSWORD_BCRYPT), is_admin: true);
                $session = new Session(id: 'sess-xyz', user_id: '1', ip_address: $ip, user_agent: $ua, created_at: new DateTime());
                return ['user' => $user, 'session' => $session];
            }
        };
        // Usa o container base para tudo e sobrescreve a entry específica
        $baseContainer->set('authenticateUseCase', $fakeUseCase);

        AppFactory::setContainer($baseContainer);
        $app = AppFactory::create();
        $app->addRoutingMiddleware();
        (require __DIR__ . '/../../src/infra/http/routes/api/index.php')($app);

        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_USER_AGENT'] = 'PHPUnit';

        $request = (new \Slim\Psr7\Factory\ServerRequestFactory())->createServerRequest('POST', '/admin/login');
        $request = $request->withParsedBody(['login' => 'admin', 'password' => 'right']);
        $response = $app->handle($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('/admin', $response->getHeaderLine('Location'));
    }

    public function test_can_access_admin_after_session_cookie_present(): void
    {
        $container = require __DIR__ . '/../../src/infra/container/index.php';
        AppFactory::setContainer($container);
        $app = AppFactory::create();
        $app->addRoutingMiddleware();
        (require __DIR__ . '/../../src/infra/http/routes/views/index.php')($app);

        // Preparar DB: person, user admin e session
        $sql = new SQL();
        $sql->insert('persons', ['name' => 'Admin', 'email' => 'admin@example.com', 'phone' => 0]);
        $personId = $sql->select('SELECT id FROM persons ORDER BY id DESC LIMIT 1')[0]['id'];
        $sql->insert('users', [
            'person_id' => (int)$personId,
            'login' => 'admin',
            'password_hash' => password_hash('right', PASSWORD_BCRYPT),
            'is_admin' => 1,
        ]);
        $userId = $sql->select('SELECT id FROM users ORDER BY id DESC LIMIT 1')[0]['id'];

    $sessionId = 'sess-test-' . bin2hex(random_bytes(4));
        $ip = '127.0.0.1';
        $ua = 'PHPUnit';
        $sql->insert('sessions', [
            'id' => $sessionId,
            'ip_address' => $ip,
            'user_agent' => $ua,
            'user_id' => (int)$userId,
        ]);

        // Variáveis globais que o middleware lê
        $_SERVER['REMOTE_ADDR'] = $ip;
        $_SERVER['HTTP_USER_AGENT'] = $ua;

        // O middleware lê diretamente $_COOKIE
        $_COOKIE['SESSION_ID'] = $sessionId;
        // Requisição
        $request = (new \Slim\Psr7\Factory\ServerRequestFactory())
            ->createServerRequest('GET', '/admin');

        $response = $app->handle($request);
        $this->assertSame(200, $response->getStatusCode());

    // Limpeza
    unset($_COOKIE['SESSION_ID']);
        $sql->delete('sessions', ['id' => $sessionId]);
        $sql->delete('users', ['id' => (int)$userId]);
        $sql->delete('persons', ['id' => (int)$personId]);
    }
}
