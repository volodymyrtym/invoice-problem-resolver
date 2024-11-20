<?php

declare(strict_types=1);

namespace App\Common\Exception;

class InvalidInputException extends \Exception
{
    public static function forField(string $field): self
    {
        return new self('Invalid field value'. $field);
    }
}
