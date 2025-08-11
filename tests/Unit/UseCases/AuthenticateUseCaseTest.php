<?php

use PHPUnit\Framework\TestCase;
use src\core\use_cases\AuthenticateUseCase;
use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;
use src\core\services\SessionServiceInterface;
use src\core\entities\User;
use src\core\entities\Session;

class AuthenticateUseCaseTest extends TestCase
{
    public function test_user_not_found_throws_exception(): void
    {
        $usersRepo = $this->createMock(UsersRepositoryInterface::class);
        $usersRepo->method('find')->willReturn(null);
        $sessionSvc = $this->createMock(SessionServiceInterface::class);

        $useCase = new AuthenticateUseCase($usersRepo, $sessionSvc);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User not found');
        $useCase->execute('john', 'secret');
    }

    public function test_invalid_password_throws_exception(): void
    {
        $user = new User(id: '1', login: 'john', password_hash: password_hash('right', PASSWORD_BCRYPT));

        $usersRepo = $this->createMock(UsersRepositoryInterface::class);
        $usersRepo->method('find')->willReturn($user);

        $sessionSvc = $this->createMock(SessionServiceInterface::class);

        $useCase = new AuthenticateUseCase($usersRepo, $sessionSvc);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid password');
        $useCase->execute('john', 'wrong');
    }

    public function test_success_returns_user_and_session(): void
    {
        $user = new User(id: '1', login: 'john', password_hash: password_hash('right', PASSWORD_BCRYPT));

        $usersRepo = $this->createMock(UsersRepositoryInterface::class);
        $usersRepo->method('find')->willReturn($user);

        $session = new Session(id: 'sess-1', user_id: '1', ip_address: '127.0.0.1', user_agent: 'PHPUnit');
        $sessionSvc = $this->createMock(SessionServiceInterface::class);
        $sessionSvc->expects($this->once())
            ->method('createSession')
            ->with($user, '127.0.0.1', 'PHPUnit')
            ->willReturn($session);

        $useCase = new AuthenticateUseCase($usersRepo, $sessionSvc);

        $result = $useCase->execute('john', 'right', '127.0.0.1', 'PHPUnit');
        $this->assertSame($user, $result['user']);
        $this->assertSame($session, $result['session']);
    }
}
