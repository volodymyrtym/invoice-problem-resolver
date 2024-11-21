<?php

declare(strict_types=1);

namespace App\Authorization;

use App\AuthenticationContract\AuthenticationProvider;
use App\Authorization\Enum\PermissionDomainsEnum;
use App\AuthorizationContract\PermissionGranter;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class PermissionGranterImpl implements PermissionGranter
{
    private const string GRANT_ALL = 'all';

    public function __construct(
        private PermissionRepository $voterRepository,
        private AuthorizationCheckerInterface $authorizationChecker,
        private AuthenticationProvider $authenticationProvider,
    ) {}

    public function grant(PermissionDomainsEnum $domain, string $permission, string $subjectId, string $userId): void
    {
        $this->voterRepository->save(domain: $domain, permission: $permission, subjectId: $subjectId, userId: $userId);
    }

    public function grantAll(PermissionDomainsEnum $domain, string $subjectId, string $userId): void
    {
        $this->voterRepository->save(
            domain: $domain,
            permission: self::GRANT_ALL,
            subjectId: $subjectId,
            userId: $userId,
        );
    }

    public function dennyUnlessGranted(string $permission, string $userId, string|null $subject = null): void
    {
        $this->authenticationProvider->dennyUnlessUserEquals($userId);
        if(!$this->authorizationChecker->isGranted(attribute: $permission, subject: $subject)){
            throw new AccessDeniedHttpException();
        }
    }
}
