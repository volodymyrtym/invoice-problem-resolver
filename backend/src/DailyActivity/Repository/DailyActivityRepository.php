<?php

declare(strict_types=1);

namespace App\DailyActivity\Repository;

use App\DailyActivity\Entity\DailyActivity;
use App\UserContract\ValueObject\UserId;
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

    public function countToday(UserId $userId): int
    {
        $startOfDay = (new \DateTimeImmutable('today'))->setTime(0, 0, 0);
        $endOfDay = $startOfDay->setTime(23, 59, 59);

        $qb = $this->entityManager->createQueryBuilder();

        $qb->from(DailyActivity::class, 'da')
            ->select('COUNT(da.id)')
            ->where('da.userId = :userId')
            ->andWhere('da.createdAt BETWEEN :startOfDay AND :endOfDay')
            ->setParameter('userId', $userId->toString())
            ->setParameter('startOfDay', $startOfDay)
            ->setParameter('endOfDay', $endOfDay);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
