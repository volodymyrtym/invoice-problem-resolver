<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

class DurationCalculator
{

    /**
     * @param int $seconds
     * @return array{minutes: int, hours: int}
     */
    public function toHoursWithMinutes(int $seconds): array
    {
        $durationHours = intdiv($seconds, 3600);
        $durationMinutes = intdiv($seconds % 3600, 60);

        return ['minutes' => $durationMinutes, 'hours' => $durationHours];
    }
}
