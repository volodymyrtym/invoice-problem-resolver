<?php

declare(strict_types=1);

namespace App\User\Repository;

use App\User\Entity\User;
use App\UserContract\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class PostgrUserRepository implements UserRepository
{

    public function __construct(private EntityManagerInterface $entityManager) {}

    public function findByEmail(string $email): ?User {}

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function get(UserId $userId): User
    {
        return $this->entityManager->find(User::class, $userId->toString());
    }
}
