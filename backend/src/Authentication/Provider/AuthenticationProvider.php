<?php

declare(strict_types=1);

namespace App\Authentication\Provider;

use App\AuthenticationContract\AuthenticationProviderInterface;
use App\AuthenticationContract\AuthenticatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

final readonly class AuthenticationProvider implements AuthenticatorInterface
{
    public function __construct(
        private Security $security,
    ) {}

    public function dennyUnlessUserEquals(string $userId): void
    {
        $authenticatedUser = $this->security->getUser();
        if (is_null($authenticatedUser)) {
            throw new AuthenticationException('Not authenticated user');
        }

        if ($authenticatedUser->getUserIdentifier() !== $userId) {
            throw new AuthenticationException('User auth missmatch');
        }
    }

    #[\Override] public function allowAuthenticateForUser(string $userId): string
    {
        // TODO: Implement allowAuthenticateForUser() method.
    }
}
