<?php

declare(strict_types=1);

namespace App\DailyActivity\ValueObject;

use App\Common\Exception\InvalidInputException;

final readonly class DailyActivityDateRange
{
    public function __construct(public \DateTimeImmutable $start, public \DateTimeImmutable $end)
    {
        if ($start->format('Y-m-d') !== $end->format('Y-m-d')) {
            throw new InvalidInputException('Daily activity date range start and end date are not valid');
        }

        if ($end <= $start) {
            throw new InvalidInputException('Start date must be lower than the end date');
        }
    }
}
