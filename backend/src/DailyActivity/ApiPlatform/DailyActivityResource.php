<?php

declare(strict_types=1);

namespace App\DailyActivity\ApiPlatform;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\DailyActivity\UseCase\Add\AddController;

#[ApiResource(
    shortName: 'DailyActivity',
    operations: [
        new Post(
            description: 'Creates activity',
            normalizationContext: ['groups' => ['daily_activity:add']],
            denormalizationContext: ['groups' => ['daily_activity:add']],
            processor: AddController::class,
        ),
    ],
)]
final class DailyActivityResource
{
    public function __construct(
        #[ApiProperty(readable: true, writable: false, identifier: true)]
        public ?string $id,
        #[Groups(['daily_activity:add'])]
        public ?string $userId,
        #[Groups(['daily_activity:add'])]
        public ?string $type,
        #[Groups(['daily_activity:add'])]
        public ?\DateTimeImmutable $from,
        #[Groups(['daily_activity:add'])]
        public ?\DateTimeImmutable $to,
        #[Groups(['daily_activity:add'])]
        public ?string $description,
    ) {}
}
