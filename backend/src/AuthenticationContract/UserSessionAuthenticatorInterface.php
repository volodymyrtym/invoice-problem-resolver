<?php

declare(strict_types=1);

namespace App\AuthenticationContract;

interface UserSessionAuthenticatorInterface
{
    public function allowAuthenticate(string $userId): void;
}
