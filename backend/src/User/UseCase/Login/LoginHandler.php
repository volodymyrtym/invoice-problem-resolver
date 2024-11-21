<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

use App\Common\Exception\InvalidInputException;
use App\Common\Service\Clock;
use App\User\Repository\UserRepository;

final readonly class LoginHandler
{
    public function __construct(
        private UserRepository $repository,
        private Clock $clock,
        private UserAuthenticator $authenticator,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function handler(string $email, string $password): LoginResult
    {
        $user = $this->repository->findByEmail($email);
        if (!$user) {
            throw new InvalidInputException('');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new InvalidInputException('Wrong password');
        }

        $user->logged($this->clock->now());
        $authToken = $this->authenticator->allowAuthenticateForUser($user->getId()->toString());
        $this->repository->save($user);

        return new LoginResult(userId: $user->getId()->toString(), authToken: $authToken);
    }
}
