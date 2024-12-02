<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\User\ValueObject\PasswordHash;
use App\User\ValueObject\UserEmail;
use App\UserContract\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "string", unique: true)]
    private string $id;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private null|\DateTimeImmutable $lastLoginAt = null;

    #[ORM\Column(type: "string", length: 320, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 60,)]
    private string $password;

    public function __construct(UserId $id, UserEmail $email, PasswordHash $password, \DateTimeImmutable $createdAt)
    {
        $this->id = $id->toString();
        $this->email = $email->value;
        $this->password = $password->value;
        $this->createdAt = $createdAt;
    }

    public function getId(): UserId
    {
        return new UserId($this->id);
    }

    public function logged(\DateTimeImmutable $at): void
    {
        $this->lastLoginAt = $at;
    }

    public function resetPassword(string $passwordHash): void
    {
        $this->password = $passwordHash;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function getPassword(): PasswordHash
    {
        return new PasswordHash($this->password);
    }
}
