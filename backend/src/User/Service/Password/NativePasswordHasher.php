<?php

declare(strict_types=1);

namespace App\User\Service\Password;

use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher as VendorHasher;

final readonly class NativePasswordHasher implements PasswordHasherInterface
{
    public function verify(string $hashedPassword, #[\SensitiveParameter] string $plainPassword): bool
    {
        return $this->getHasher()->verify(hashedPassword: $hashedPassword, plainPassword: $plainPassword);
    }

    public function hash(#[\SensitiveParameter] string $plainPassword): string
    {
        return $this->getHasher()->hash($plainPassword);
    }

    private function getHasher(): VendorHasher
    {
        return new VendorHasher(
            cost: 13,
        );
    }
}
