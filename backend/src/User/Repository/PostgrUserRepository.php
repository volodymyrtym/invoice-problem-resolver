<?php

declare(strict_types=1);

namespace App\User\Repository;

use App\User\Entity\User;

final readonly class PostgrUserRepository implements UserRepository
{
    public function findByEmail(string $email): ?User {}

    public function save(User $user): void {}
}
