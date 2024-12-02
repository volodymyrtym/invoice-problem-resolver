<?php

declare(strict_types=1);

namespace App\User\UseCase\ResetPassword;

class ResetPasswordCommand
{
    public function __construct(public string $newPassword, public string $userId) {}
}
