<?php

declare(strict_types=1);

namespace App\DailyActivity\Repository;

use App\DailyActivity\Entity\DailyActivity;
use App\DailyActivity\ValueObject\DailyActivityId;

interface DailyActivityRepository
{
    public function save(DailyActivity $entity): void;
}
