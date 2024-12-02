<?php

declare(strict_types=1);

namespace App\DailyActivity\Enum;

enum ActivityTypeEnum: string
{
    case Work = 'work';
    case SeekLeave = 'sickness';
    case Vacation = 'vacation';
}
