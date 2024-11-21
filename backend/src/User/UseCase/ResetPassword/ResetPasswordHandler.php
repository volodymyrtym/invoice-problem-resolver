<?php

declare(strict_types=1);

namespace App\User\UseCase\ResetPassword;

use App\User\Repository\UserRepository;
use App\User\Service\PasswordHasher;
use App\UserContract\ValueObject\UserId;

class ResetPasswordHandler
{
    public function __construct(private UserRepository $userRepository, private PasswordHasher $passwordHasher) {}

    public function handle(ResetPasswordCommand $command): void
    {
        $user = $this->userRepository->get(UserId::fromString($command->userId));
        $user->resetPassword($this->passwordHasher->hash($command->newPassword));
        $this->userRepository->save($user);
    }
}
