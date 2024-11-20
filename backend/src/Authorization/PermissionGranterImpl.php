<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Enum\PermissionDomainsEnum;

final readonly class PermissionGranterImpl implements PermissionGranter
{
    private const string GRANT_ALL = 'all';

    public function __construct(private PermissionRepository $voterRepository) {}

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
}
