<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Add;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Authorization\Enum\PermissionDomainsEnum;
use App\AuthorizationContract\Enum\DailyActivityPermission;
use App\AuthorizationContract\PermissionGranterInterface;
use Webmozart\Assert\Assert;

final readonly class AddController implements ProcessorInterface
{
    public function __construct(
        private AddHandler $handler,
        private PermissionGranterInterface $permissionGranter,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, AddCommand::class);
        /** @var AddCommand $data */
        $this->permissionGranter->dennyUnlessGranted(
            permission: DailyActivityPermission::Create->value,
            userId: $data->userId,
        );

        $id = $this->handler->handle($data);

        $this->permissionGranter->grantAll(
            domain: PermissionDomainsEnum::DailyActivity,
            subjectId: $id,
            userId: $data->userId,
        );
    }
}
