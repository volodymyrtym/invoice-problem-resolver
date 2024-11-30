<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList\Repository;

final readonly class RepositoryDailyActivityItem
{
    public function __construct(
        public string $id,
        public ?string $projectName,
        public \DateTimeImmutable $startAt,
        public \DateTimeImmutable $endAt,
        public string $description,
    ) {}
}
