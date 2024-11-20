<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Enum\PermissionDomainsEnum;

class PermissionRepository
{
    public function save(PermissionDomainsEnum $domain, string $permission, string $subjectId, string $userId): void
    {
        //todo implement
        throw new \RuntimeException('Not implemented');
    }

    public function hasAllPermission(PermissionDomainsEnum $domain, string $subjectId, string $userId): bool
    {
        throw new \RuntimeException('Not implemented');
        return true;
    }
}
