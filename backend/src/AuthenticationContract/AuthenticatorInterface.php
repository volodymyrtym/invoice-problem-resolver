<?php

declare(strict_types=1);

namespace App\AuthenticationContract;

interface AuthenticatorInterface
{
    public function allowAuthenticateForUser(string $userId): string;

    public function dennyUnlessUserEquals(string $userId): void;
}
