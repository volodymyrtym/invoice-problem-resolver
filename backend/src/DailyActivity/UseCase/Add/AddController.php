<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Add;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Authentication\RequestUserIdProvider;
use App\Authorization\Enum\PermissionDomainsEnum;
use App\Authorization\PermissionGranter;
use App\DailyActivity\ApiPlatform\DailyActivityResource;
use Webmozart\Assert\Assert;

final class AddController implements ProcessorInterface
{
    public function __construct(
        private AddHandler $handler,
        private PermissionGranter $permissionGranter,
        private RequestUserIdProvider $requestUserIdProvider,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, DailyActivityResource::class);
        $userID = $this->requestUserIdProvider->getUserOrDennyRequest();
        /** @var DailyActivityResource $data */
        Assert::notNull($data->description);
        Assert::notNull($data->from);
        Assert::notNull($data->to);
        Assert::notNull($data->type);

        $id = $this->handler->handle(
            new AddCommand(
                userId: $userID,
                type: $data->type,
                from: $data->from,
                to: $data->to,
                description: $data->description,
            ),
        );

        $this->permissionGranter->grantAll(
            domain: PermissionDomainsEnum::DailyActivity,
            subjectId: $id,
            userId: $userID,
        );
    }
}
