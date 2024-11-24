<?php

declare(strict_types=1);

namespace App\Authentication\User;

use App\UserContract\ValueObject\UserId;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class SecurityUser implements UserInterface
{
    public function __construct(private UserId $userId, private array $userRoles) {}

    public function getRoles(): array
    {
        return $this->userRoles;
    }

    public function getUserIdentifier(): string
    {
        return $this->userId->toString();
    }

    public function eraseCredentials(): void
    {
        // Можна залишити порожнім, якщо доменна модель не має незашифрованих даних
    }
}
