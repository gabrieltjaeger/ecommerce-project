<?php
namespace src\infra\contexts;

use src\core\entities\User;
use src\core\services\SessionServiceInterface;
use src\core\repositories\UsersRepositoryInterface;
use src\core\repositories\requests\UserSearchRequest;

class AuthContext
{
    public function __construct(
        private SessionServiceInterface $sessionService,
        private UsersRepositoryInterface $usersRepository
    ) {}

    public function getAuthenticatedUser(): ?User
    {
        $userId = $this->sessionService->getCurrentUserId();
        if (!$userId) {
            return null;
        }
        $userRequest = new UserSearchRequest(id: $userId);
        return $this->usersRepository->find($userRequest);
    }
}
