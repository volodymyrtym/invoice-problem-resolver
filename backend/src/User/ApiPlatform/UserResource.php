<?php

declare(strict_types=1);

namespace App\DailyActivity\ApiPlatform;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\DailyActivity\UseCase\Add\AddCommand;
use App\DailyActivity\UseCase\Add\AddController;

#[ApiResource(
    uriTemplate: '/daily_activities',
    shortName: 'DailyActivity',
    operations: [
        new Post(
            status: 201,
            description: 'Creates activity',
            input: AddCommand::class,
            output: null,
            processor: AddController::class,
        ),
    ],
)]
final class UserResource
{
    public function __construct() {}
}
