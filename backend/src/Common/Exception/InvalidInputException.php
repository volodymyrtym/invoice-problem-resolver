<?php

declare(strict_types=1);

namespace App\Common\Exception;

class InvalidInputException extends \Exception
{
    public static function forField(string $field, string $value): self
    {
        return new self(sprintf('Invalid field `%s` with value `%s`,', $field, $value));
    }
}
