<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList\Repository;

use App\DailyActivity\UseCase\GetList\GetListQuery;
use Doctrine\ORM\EntityManagerInterface;

class GetListRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getList(GetListQuery $query): RepositoryQueryResult
    {
        $offset = ($query->page - 1) * $query->limit;

        $sql = <<<SQL
         SELECT id, user_id, type, start_at, end_at, description, DATE(start_at) AS activity_date
    FROM daily_activity_daily_activities
    WHERE user_id = :userId
      AND DATE(start_at) IN (
          SELECT DISTINCT DATE(start_at) AS activity_date
          FROM daily_activity_daily_activities
          WHERE user_id = :userId
          ORDER BY activity_date DESC
          LIMIT :limit OFFSET :offset
      )
    ORDER BY start_at DESC
SQL;

        $arrayResults = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['limit' => $query->limit, 'offset' => $offset, 'userId' => $query->userId],
        )->fetchAllAssociative();

        $items = [];
        foreach ($arrayResults as $arrayResult) {
            $items[] = new RepositoryDailyActivityItem(
                id: $arrayResult['id'],
                type: $arrayResult['type'],
                startAt: new \DateTimeImmutable($arrayResult['start_at']),
                endAt: new \DateTimeImmutable($arrayResult['end_at']),
                description: $arrayResult['description'],
            );
        }
        $hasNextPage = false;
        if (!empty($items)) {
            $hasNextPage = $this->hasNextDate($query->userId, end($items)->startAt);
        }

        return new RepositoryQueryResult($query->page !== 1, $hasNextPage, ...$items);
    }

    private function hasNextDate(string $userId, \DateTimeImmutable $oldestDate): bool
    {
        $sql = <<<SQL
    SELECT EXISTS (
        SELECT 1
        FROM daily_activity_daily_activities
        WHERE user_id = :userId
          AND DATE(start_at) < :oldestDate
    ) AS next_exists LIMIT 1
SQL;

        return (bool)$this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'userId' => $userId,
                'oldestDate' => $oldestDate->format('Y-m-d'),
            ],
        )->fetchOne();
    }
}
