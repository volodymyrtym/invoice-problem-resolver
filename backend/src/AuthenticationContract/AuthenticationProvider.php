<?php

declare(strict_types=1);

namespace App\AuthenticationContract;

interface AuthenticationProvider
{
    public function dennyUnlessUserEquals(string $userId): void;
}
