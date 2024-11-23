<?php

declare(strict_types=1);

namespace App\User\ValueObject;

use Webmozart\Assert\Assert;

final readonly class UserEmail
{
    public function __construct(public string $value)
    {
        Assert::lengthBetween($this->value, 4, 320);
    }
}
