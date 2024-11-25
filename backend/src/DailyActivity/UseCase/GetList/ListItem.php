<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

final readonly class ListItem
{
    public function __construct(
        public string $id,
        public string $type,
        public \DateTimeImmutable $startAt,
        public \DateTimeImmutable $endAt,
        public string $description,
    ) {}
}
