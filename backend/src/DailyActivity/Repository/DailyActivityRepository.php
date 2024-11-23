<?php

declare(strict_types=1);

namespace App\DailyActivity\Repository;

use App\DailyActivity\Entity\DailyActivity;
use Doctrine\ORM\EntityManagerInterface;

class DailyActivityRepository implements DailyActivityRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(DailyActivity $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
