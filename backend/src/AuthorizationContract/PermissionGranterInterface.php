<?php

declare(strict_types=1);

namespace App\AuthorizationContract;

use App\Authorization\Enum\PermissionDomainsEnum;

interface PermissionGranterInterface
{
    public function dennyUnlessGranted(string $permission, string $userId, string|null $subject = null): void;

    public function grant(PermissionDomainsEnum $domain, string $permission, string $subjectId, string $userId): void;

    public function grantAll(PermissionDomainsEnum $domain, string $subjectId, string $userId): void;
}
