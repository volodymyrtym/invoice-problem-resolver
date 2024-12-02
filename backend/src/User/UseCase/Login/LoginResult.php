<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

final readonly class LoginResult
{
    public function __construct(public string $userId, public string $authToken) {}
}
