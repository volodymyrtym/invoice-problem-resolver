<?php

declare(strict_types=1);

namespace App\DailyActivity\ApiPlatform;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\QueryParameter;
use App\DailyActivity\UseCase\Create\ApiCreateRequest;
use App\DailyActivity\UseCase\Create\CreateCommand;
use App\DailyActivity\UseCase\Create\ApiCreateController;
use App\DailyActivity\UseCase\GetList\ApiGetListController;
use App\DailyActivity\UseCase\GetList\GetListResult;

#[ApiResource(
    uriTemplate: '/daily-activities',
    shortName: 'DailyActivity',
    operations: [
        new Post(
            status: 201,
            description: 'Creates activity',
            input: ApiCreateRequest::class,
            output: null,
            processor: ApiCreateController::class,
        ),
        new Get(
            uriTemplate: '/daily-activities',
            status: 200,
            description: 'Get daily activities',
            output: GetListResult::class,
            provider: ApiGetListController::class,
            parameters: [
                'page' => new QueryParameter(required: true),
                'limit' => new QueryParameter(required: true),
                'userId' => new QueryParameter(required: true),
            ],
        ),
    ],
)]
final class DailyActivityResource
{
    public function __construct() {}
}
