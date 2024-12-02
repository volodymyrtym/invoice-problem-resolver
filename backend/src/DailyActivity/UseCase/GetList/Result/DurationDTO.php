<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList\Result;

class DurationDTO
{
    public function __construct(public int $hours, public int $minutes) {}
}
