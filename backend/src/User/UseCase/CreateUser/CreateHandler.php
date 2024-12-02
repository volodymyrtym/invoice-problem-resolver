<?php

declare(strict_types=1);

namespace App\User\UseCase\CreateUser;

use App\Common\Exception\InvalidInputException;
use App\User\Entity\User;
use App\User\Repository\UserRepositoryInterface;
use App\User\Service\Password\PasswordHasherInterface;
use App\User\Service\Password\PasswordValidatorInterface;
use App\User\ValueObject\PasswordHash;
use App\User\ValueObject\UserEmail;
use App\UserContract\ValueObject\UserId;
use Psr\Clock\ClockInterface;

class CreateHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordValidatorInterface $passwordValidator,
        private PasswordHasherInterface $passwordHasher,
        private ClockInterface $clock,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function handle(CreateCommand $command): string
    {
        if ($validationError = $this->passwordValidator->validate($command->password)) {
            throw new InvalidInputException($validationError);
        }

        if($this->userRepository->findByEmail(new UserEmail($command->email))){
            throw new InvalidInputException('You already have an account. Try to restore it');
        }

        $hashedPassword = $this->passwordHasher->hash($command->password);
        $userId = UserId::create();
        $this->userRepository->save(
            new User(
                id: $userId,
                email: new UserEmail($command->email),
                password: new PasswordHash($hashedPassword),
                createdAt: $this->clock->now(),
            ),
        );

        return $userId->toString();
    }
}
