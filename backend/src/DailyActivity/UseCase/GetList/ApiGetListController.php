<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\AuthenticationContract\CurentUserProviderInterface;
use App\AuthorizationContract\Enum\DailyActivityPermission;
use App\AuthorizationContract\PermissionGranterInterface;
use Webmozart\Assert\Assert;

readonly class ApiGetListController implements ProviderInterface
{
    private const int MAX_ITEMS_ON_PAGE = 50;

    public function __construct(
        private PermissionGranterInterface $permissionGranter,
        private GetListHandler $handler,
        private CurentUserProviderInterface $userProvider,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): GetListResult
    {
        $filters = $context['filters'];
        $limit = (int)($filters['limit'] ?? self::MAX_ITEMS_ON_PAGE);
        Assert::range($limit, 1, self::MAX_ITEMS_ON_PAGE, 'Wrong items in page qty');
        $page = (int)($filters['page'] ?? 1);
        Assert::greaterThanEq($page, 1);

        $this->permissionGranter->dennyUnlessGranted(DailyActivityPermission::List->value);

        return $this->handler->handle(
            new GetListQuery(
                page: $page,
                limit: $limit,
                userId: $this->userProvider->provideId(),
            ),
        );
    }
}
