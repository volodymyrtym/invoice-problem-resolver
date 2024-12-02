<?php

declare(strict_types=1);

namespace App\AuthenticationContract;

interface UserApiAuthenticatorInterface
{
    public function allowAuthenticate(string $userId): string;
}
