<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

class GroupedByDateActivities
{
    public array $items;

    public function __construct(
        public string $date,
        DailyActivityViewItem ...$items
    ) {
        $this->items = $items;
    }
}
