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
        public \DateTimeImmutable $from,
        public \DateTimeImmutable $to,
        public string $description,
    ) {}
}
