<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList\Result;

class DailyActivitiesCollection
{
    public array $items;

    public function __construct(
        public string $date,
        public DurationDTO $duration,
        DailyActivityItem ...$items
    ) {
        $this->items = $items;
    }
}
