<?php

declare(strict_types=1);

namespace App\DailyActivity\Repository;

use App\DailyActivity\Entity\DailyActivity;
use Doctrine\ORM\EntityManagerInterface;

class DailyActivityWriteRepository
{
    public function __construct(protected EntityManagerInterface $entityManager) {}

    public function save(DailyActivity $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
