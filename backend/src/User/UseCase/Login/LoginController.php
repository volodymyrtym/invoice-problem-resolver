<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Webmozart\Assert\Assert;

final readonly class LoginController implements ProcessorInterface
{
    public function __construct(
        private LoginHandler $handler,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($data, LoginCommand::class);
        /** @var LoginCommand $data */
        return $this->handler->handle($data);
    }
}
