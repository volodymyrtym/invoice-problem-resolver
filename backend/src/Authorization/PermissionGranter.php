<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Enum\PermissionDomainsEnum;

interface PermissionGranter
{
    public function grant(PermissionDomainsEnum $domain, string $permission, string $subjectId, string $userId): void;

    public function grantAll(PermissionDomainsEnum $domain, string $subjectId, string $userId): void;
}
