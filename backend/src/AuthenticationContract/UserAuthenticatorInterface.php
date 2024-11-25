<?php

declare(strict_types=1);

namespace App\AuthenticationContract;

interface UserAuthenticatorInterface
{
    public function allowAuthenticate(string $userId): string;

    public function dennyUnlessTokenUserEquals(string $userId): void;
}
