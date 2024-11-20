<?php

namespace App\User\ValueObject;

class UserEmail
{
    public function __construct(public string $value) {
        //todo validation
    }
}
