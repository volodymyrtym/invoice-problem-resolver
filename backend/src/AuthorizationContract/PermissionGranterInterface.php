<?php

declare(strict_types=1);

namespace App\AuthorizationContract;

interface PermissionGranterInterface
{
    public function dennyUnlessGranted(string $permission, string $userId, string|null $subject = null): void;
}
