<?php

declare(strict_types=1);

namespace App\Authorization;

use App\AuthenticationContract\RoleEnum;
use App\AuthorizationContract\PermissionGranterInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class PermissionGranter implements PermissionGranterInterface
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    public function dennyUnlessGranted(string $permission, string|null $subject = null): void
    {
        if (!$this->authorizationChecker->isGranted(RoleEnum::User->value)) { //voter concept if needed
            throw new AccessDeniedHttpException();
        }
    }
}
