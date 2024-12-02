<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\AuthenticationContract\UserApiAuthenticatorInterface;
use Webmozart\Assert\Assert;

final readonly class ApiLoginController implements ProcessorInterface
{
    public function __construct(
        private LoginHandler $handler,
        private UserApiAuthenticatorInterface $authenticator,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): LoginResult {
        Assert::isInstanceOf($data, LoginCommand::class);
        $userId = $this->handler->handle($data);
        $authToken = $this->authenticator->allowAuthenticate($userId);

        /** @var LoginCommand $data */
        return new LoginResult(userId: $userId, authToken: $authToken);
    }
}
