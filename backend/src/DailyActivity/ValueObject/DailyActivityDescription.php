<?php

declare(strict_types=1);

namespace App\DailyActivity\ValueObject;

use Webmozart\Assert\Assert;

final readonly class DailyActivityDescription
{
    public function __construct(private string $value)
    {
        Assert::lengthBetween($this->value, 1, 256);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
