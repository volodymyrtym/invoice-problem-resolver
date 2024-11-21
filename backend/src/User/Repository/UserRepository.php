<?php

declare(strict_types=1);

namespace App\User\Repository;

use App\User\Entity\User;
use App\UserContract\ValueObject\UserId;

interface UserRepository
{
    public function get(UserId $userId): User;

    public function findByEmail(string $email): ?User;

    public function save(User $user): void;
}
