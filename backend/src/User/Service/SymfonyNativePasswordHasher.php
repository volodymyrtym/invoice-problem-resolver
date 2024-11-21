<?php

declare(strict_types=1);

namespace App\User\Service;

use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

class SymfonyNativePasswordHasher implements PasswordHasher
{
    public function verify(string $hashedPassword, #[\SensitiveParameter] string $plainPassword): bool
    {
        return $this->getHasher()->verify(hashedPassword: $hashedPassword, plainPassword: $plainPassword);
    }

    public function hash(#[\SensitiveParameter] string $plainPassword): string
    {
        return $this->getHasher()->hash($plainPassword);
    }

    private function getHasher(): NativePasswordHasher
    {
        return new NativePasswordHasher(
            cost: 13,
        );
    }
}
