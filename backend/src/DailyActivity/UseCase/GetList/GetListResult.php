<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

final readonly class GetListResult
{
    public array $activities;

    public function __construct(public bool $hasPrevPage, public bool $hasNextPage, GroupedByDateActivities ...$activities)
    {
        $this->activities = $activities;
    }
}
