<?php

declare(strict_types=1);

namespace App\User\UseCase\ResetPassword;

use App\User\Repository\UserRepositoryInterface;
use App\User\Service\Password\PasswordHasherInterface;
use App\UserContract\ValueObject\UserId;

class ResetPasswordHandler
{
    public function __construct(private UserRepositoryInterface $userRepository, private PasswordHasherInterface $passwordHasher) {}

    public function handle(ResetPasswordCommand $command): void
    {
        $user = $this->userRepository->get(UserId::fromString($command->userId));
        $user->resetPassword($this->passwordHasher->hash($command->newPassword));
        $this->userRepository->save($user);
    }
}
