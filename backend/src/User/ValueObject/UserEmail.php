<?php

declare(strict_types=1);

namespace App\User\ValueObject;

use App\Common\Exception\InvalidInputException;
use Webmozart\Assert\Assert;

final readonly class UserEmail
{
    public function __construct(public string $value)
    {
        try {
            Assert::lengthBetween($this->value, 4, 320, "Wrong email length");
            Assert::email($this->value, "Wrong email");
        }
        catch (\Exception $exception) {
            throw new InvalidInputException($exception->getMessage());
        }
    }
}
