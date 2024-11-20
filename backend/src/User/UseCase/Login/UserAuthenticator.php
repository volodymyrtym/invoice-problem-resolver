<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

interface UserAuthenticator
{
    public function allowAuthenticateForUser(string $userId): string;
}
