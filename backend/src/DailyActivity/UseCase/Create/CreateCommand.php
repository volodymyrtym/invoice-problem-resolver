<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Create;

use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
final readonly class CreateCommand
{
    public function __construct(
        public string $userId,
        public string $type,
        public \DateTimeImmutable $start,
        public \DateTimeImmutable $end,
        public string $description,
    ) {}
}
