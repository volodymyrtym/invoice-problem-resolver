<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Add;

use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
final readonly class AddCommand
{
    public function __construct(
        public string $userId,
        public string $type,
        public \DateTimeImmutable $from,
        public \DateTimeImmutable $to,
        public string $description,
    ) {}
}
