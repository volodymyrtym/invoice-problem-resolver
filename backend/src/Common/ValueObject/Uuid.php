<?php

declare(strict_types=1);

namespace App\Common\ValueObject;

use App\Common\Exception\InvalidInputException;
use Symfony\Component\Uid\UuidV6;

abstract class Uuid
{
    public function __construct(private string $value)
    {
        if (!UuidV6::isValid($this->value)) {
            throw new InvalidInputException('Wrong uuid code ' . $this->value);
        }
    }

    public static function create(): static
    {
        return new static(UuidV6::generate());
    }

    public static function fromString(string $uuid): static
    {
        return new static($uuid);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
