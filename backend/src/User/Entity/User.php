<?php

namespace App\User\Entity;

use App\User\ValueObject\UserEmail;
use App\User\ValueObject\UserId;

class User
{
    private \DateTimeImmutable $createdAt;
    private null|\DateTimeImmutable $lastLoginAt = null;

    public function __construct(private UserId $id, private UserEmail $email, private string $password) {}

    public function getId(): UserId
    {
        return $this->id;
    }

    public function logged(\DateTimeImmutable $at): void
    {
        $this->lastLoginAt = $at;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
