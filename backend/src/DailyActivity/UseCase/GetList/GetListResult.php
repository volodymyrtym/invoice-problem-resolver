<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

use App\DailyActivity\UseCase\GetList\Result\DailyActivitiesCollection;

final readonly class GetListResult
{
    public array $activities;

    public function __construct(public bool $hasPrevPage, public bool $hasNextPage, DailyActivitiesCollection ...$activities)
    {
        $this->activities = $activities;
    }
}
