<?php

declare(strict_types=1);

namespace App\DailyActivity\Enum;

enum ActivityEnum: string
{
    case Work = 'work';
    case SeekLeave = 'seek leave';
    case Vacation = 'vacation';
}
