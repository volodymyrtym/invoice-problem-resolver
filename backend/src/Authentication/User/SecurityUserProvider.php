<?php

declare(strict_types=1);

namespace App\Authentication\User;

use App\AuthenticationContract\RoleEnum;
use App\UserContract\ValueObject\UserId;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final readonly class SecurityUserProvider implements UserProviderInterface
{
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SecurityUser) {
            throw new \InvalidArgumentException('Invalid user type');
        }

        return $this->createUser($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === SecurityUser::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->createUser($identifier);
    }

    private function createUser(string $userId): SecurityUser
    {
        return new SecurityUser(userId: UserId::fromString($userId), userRoles: [RoleEnum::User->value]);
    }
}
