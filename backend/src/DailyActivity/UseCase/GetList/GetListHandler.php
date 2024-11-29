<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

use App\DailyActivity\UseCase\GetList\Repository\GetListRepository;
use App\DailyActivity\UseCase\GetList\Repository\RepositoryDailyActivityItem;
use App\DailyActivity\UseCase\GetList\Result\DailyActivitiesCollection;
use App\DailyActivity\UseCase\GetList\Result\DailyActivityItem;
use App\DailyActivity\UseCase\GetList\Result\DurationDTO;

class GetListHandler
{
    public function __construct(
        private GetListRepository $repository,
        private DurationCalculator $durationCalculator,
    ) {}

    public function handle(GetListQuery $query): GetListResult
    {
        $activities = $this->repository->getList($query);
        $activitiyGroupedByDate = $this->toView(...$activities->items);

        return new GetListResult($activities->hasPrevPage, $activities->hasNexPage, ...$activitiyGroupedByDate);
    }

    private function toView(RepositoryDailyActivityItem ...$items): array
    {
        $grouped = [];
        $groupedDurationInSeconds = [];
        foreach ($items as $item) {
            $date = $item->startAt->format('d.m.Y');
            if (!isset($grouped[$date])) {
                $grouped[$date] = [];
            }
            $interval = $item->startAt->diff($item->endAt);
            $itemDuration = new DurationDTO(
                hours: $interval->h, minutes: $interval->m,
            );
            $grouped[$date][] = new DailyActivityItem(
                id: $item->id,
                type: $item->type,
                projectName: $item->projectName,
                duration: $itemDuration,
                description: $item->description,
            );
            if (empty($groupedDurationInSeconds[$date])) {
                $groupedDurationInSeconds[$date] = 0;
            }
            $groupedDurationInSeconds[$date] += ($item->endAt->getTimestamp() - $item->startAt->getTimestamp());
        }

        $result = [];
        foreach ($grouped as $date => $groupedItems) {
            $groupDuration = $this->durationCalculator->toHoursWithMinutes($groupedDurationInSeconds[$date]);

            $result[] = new DailyActivitiesCollection(
                $date,
                new DurationDTO(
                    hours: $groupDuration['hours'],
                    minutes: $groupDuration['minutes'],
                ),
                ...$groupedItems,
            );
        }

        return $result;
    }
}
