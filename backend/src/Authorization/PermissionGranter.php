<?php

declare(strict_types=1);

namespace App\Authorization;

use App\AuthenticationContract\RoleEnum;
use App\AuthenticationContract\UserAuthenticatorInterface;
use App\AuthorizationContract\PermissionGranterInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class PermissionGranter implements PermissionGranterInterface
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
        private UserAuthenticatorInterface $authenticator,
    ) {}

    public function dennyUnlessGranted(string $permission, string $userId, string|null $subject = null): void
    {
        $this->authenticator->dennyUnlessTokenUserEquals($userId);

        if (!$this->authorizationChecker->isGranted(RoleEnum::User->value)) { //voter concept if needed
            throw new AccessDeniedHttpException();
        }
    }
}
