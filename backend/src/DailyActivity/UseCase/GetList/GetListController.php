<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\AuthorizationContract\Enum\DailyActivityPermission;
use App\AuthorizationContract\PermissionGranterInterface;
use Webmozart\Assert\Assert;

readonly class GetListController implements ProviderInterface
{
    private const int MAX_ITEMS_ON_PAGE = 31;

    public function __construct(
        private PermissionGranterInterface $permissionGranter,
        private GetListHandler $handler,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): GetListResult
    {
        $filters = $context['filters'];
        $userId = $filters['userId'];
        $limit = (int)($filters['limit'] ?? 10);
        Assert::range($limit, 1, self::MAX_ITEMS_ON_PAGE, 'Wrong items in page qty');
        $page = (int)($filters['page'] ?? 1);
        Assert::greaterThanEq($page, 1);

        $this->permissionGranter->dennyUnlessGranted(DailyActivityPermission::List->value, $userId);

        return $this->handler->handle(
            new GetListQuery(
                page: $page,
                limit: $limit,
                userId: $userId,
            ),
        );
    }
}
