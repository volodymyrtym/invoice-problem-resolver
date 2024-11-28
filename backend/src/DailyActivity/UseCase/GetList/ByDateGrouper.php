<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

class ByDateGrouper
{
    public function group(DailyActivityViewItem ...$items): array
    {
        $grouped = [];

        foreach ($items as $item) {
            $date = $item->startAt->format('d.m.Y');
            if (!isset($grouped[$date])) {
                $grouped[$date] = [];
            }
            $grouped[$date][] = $item;
        }

        $result = [];
        foreach ($grouped as $date => $groupedItems) {
            $result[] = new GroupedByDateActivities($date, ...$groupedItems);
        }

        return $result;
    }
}
