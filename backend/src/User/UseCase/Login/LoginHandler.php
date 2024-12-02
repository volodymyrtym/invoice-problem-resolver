<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

use App\AuthenticationContract\UserApiAuthenticatorInterface;
use App\Common\Exception\InvalidInputException;
use App\User\Repository\UserRepositoryInterface;
use App\User\ValueObject\UserEmail;
use Psr\Clock\ClockInterface;

final readonly class LoginHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private ClockInterface $clock,
        private UserApiAuthenticatorInterface $authenticator,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function handle(LoginCommand $command): string
    {
        $user = $this->repository->findByEmail(new UserEmail($command->email));
        if (!$user) {
            throw new InvalidInputException('No such user');
        }

        if (!password_verify(password: $command->password, hash: $user->getPassword()->value)) {
            throw new InvalidInputException('Wrong password');
        }

        $user->logged($this->clock->now());

        $this->repository->save($user);

        return $user->getId()->toString();
    }
}
