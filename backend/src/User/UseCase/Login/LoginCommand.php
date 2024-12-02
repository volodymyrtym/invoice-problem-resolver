<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

class LoginCommand
{
    public function __construct(public string $password, public string $email) {}
}
