<?php

declare(strict_types=1);

namespace App\User\Service;

interface PasswordHasher
{
    public function verify(string $hashedPassword, #[\SensitiveParameter] string $plainPassword): bool;

    public function hash(#[\SensitiveParameter] string $plainPassword): string;
}
