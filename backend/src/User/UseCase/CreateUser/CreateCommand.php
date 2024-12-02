<?php

declare(strict_types=1);

namespace App\User\UseCase\CreateUser;

class CreateCommand
{
    public function __construct(public string $password, public string $email) {}
}
