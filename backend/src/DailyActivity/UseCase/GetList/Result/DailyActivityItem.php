<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList\Result;

final readonly class DailyActivityItem
{
    public function __construct(
        public string $id,
        public null|string $projectName,
        public DurationDTO $duration,
        public string $description,
    ) {}
}
