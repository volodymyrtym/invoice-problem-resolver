<?php

declare(strict_types=1);

namespace App\DailyActivity\ApiPlatform;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\DailyActivity\UseCase\Create\CreateCommand;
use App\DailyActivity\UseCase\Create\CreateController;

#[ApiResource(
    uriTemplate: '/daily-activities',
    shortName: 'DailyActivity',
    operations: [
        new Post(
            status: 201,
            description: 'Creates activity',
            input: CreateCommand::class,
            output: null,
            processor: CreateController::class,
        ),
    ],
)]
final class DailyActivityResource
{
    public function __construct() {}
}
