<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Create;

final readonly class ApiCreateRequest
{
    public function __construct(
        public string $date,
        public string $dateTimeFrom,
        public string $dateTimeTo,
        public string $description,
    ) {}
}
