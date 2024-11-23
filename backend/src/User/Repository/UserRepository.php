<?php

declare(strict_types=1);

namespace App\User\Repository;

use App\User\Entity\User;
use App\User\ValueObject\UserEmail;
use App\UserContract\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserRepository implements UserRepositoryInterface
{

    public function __construct(private EntityManagerInterface $entityManager) {}

    public function findByEmail(UserEmail $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email->value]);
    }

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
