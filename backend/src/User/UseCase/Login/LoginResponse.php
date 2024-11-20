<?php

namespace App\User\UseCase\Login;

final readonly class LoginResponse
{
    public function __construct(public string $userId, public string $authToken) {}
}
