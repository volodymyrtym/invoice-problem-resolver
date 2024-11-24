<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Create;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\AuthorizationContract\Enum\DailyActivityPermission;
use App\AuthorizationContract\PermissionGranterInterface;
use Webmozart\Assert\Assert;

final readonly class CreateController implements ProcessorInterface
{
    public function __construct(
        private CreateHandler $handler,
        private PermissionGranterInterface $permissionGranter,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, CreateCommand::class);
        /** @var CreateCommand $data */
        $this->permissionGranter->dennyUnlessGranted(
            permission: DailyActivityPermission::Create->value,
            userId: $data->userId,
        );

        $this->handler->handle($data);
    }
}
