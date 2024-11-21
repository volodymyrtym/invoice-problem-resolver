<?php

declare(strict_types=1);

namespace App\Authentication\Provider;

use App\AuthenticationContract\AuthenticationProvider;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final readonly class AuthenticationProviderImp implements AuthenticationProvider
{
    public function __construct(
        private Security $security,
    ) {}

    public function dennyUnlessUserEquals(string $userId): void
    {
        $authenticatedUser = $this->security->getUser();
        if (is_null($authenticatedUser)) {
            throw new BadRequestHttpException('Not authenticated user');
        }

        if ($authenticatedUser->getUserIdentifier() !== $userId) {
            throw new BadRequestHttpException('User auth missmatch');
        }
    }
}
