<?php

declare(strict_types=1);

namespace App\User\UseCase\CreateUser;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Webmozart\Assert\Assert;

final readonly class CreateController implements ProcessorInterface
{
    public function __construct(
        private CreateHandler $handler,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, CreateCommand::class);
        /** @var CreateCommand $data */

        $this->handler->handle($data);
    }
}
