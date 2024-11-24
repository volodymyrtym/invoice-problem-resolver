<?php

declare(strict_types=1);

namespace App\DailyActivity\Repository;

use App\DailyActivity\Entity\DailyActivity;
use App\UserContract\ValueObject\UserId;

interface DailyActivityRepositoryInterface
{
    public function save(DailyActivity $entity): void;

    public function countToday(UserId $userId): int;
}
