<?php

declare(strict_types=1);

namespace App\User\Service\Password;

interface PasswordValidatorInterface
{
    public function validate(string $password): ?string;
}
