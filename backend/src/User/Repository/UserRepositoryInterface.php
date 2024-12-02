<?php

declare(strict_types=1);

namespace App\User\Repository;

use App\User\Entity\User;
use App\User\ValueObject\UserEmail;
use App\UserContract\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function get(UserId $userId): User;

    public function findByEmail(UserEmail $email): ?User;

    public function save(User $user): void;
}
