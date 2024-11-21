<?php

declare(strict_types=1);

namespace App\User\ValueObject;

use Webmozart\Assert\Assert;

class PasswordHash
{
    public function __construct(public string $value)
    {
        Assert::length($this->value, 60);
    }
}
