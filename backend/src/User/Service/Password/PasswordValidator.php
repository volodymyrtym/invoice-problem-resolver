<?php

declare(strict_types=1);

namespace App\User\Service\Password;

final readonly class PasswordValidator implements PasswordValidatorInterface
{
    private const int MIN_LENGTH = 8;
    private const int MAX_LENGTH = 64;
    private const array FORBIDDEN_CHARS = [' ', "\t", "\n", "\r", "'", '"', "\\", '<', '>'];

    public function validate(string $password): ?string
    {
        if (strlen($password) < self::MIN_LENGTH || strlen($password) > self::MAX_LENGTH) {
            return sprintf('Password must be beetwen %d and %d symbols length', self::MIN_LENGTH, self::MAX_LENGTH);
        }

        foreach (self::FORBIDDEN_CHARS as $char) {
            if (str_contains($password, $char)) {
                return 'Forbiden password character `' . $char . '`';
            }
        }

        if (!preg_match('/[a-zA-Z]/', $password)) {
            return 'Password must contain at least one letter.';
        }

        if (!preg_match('/\d/', $password)) {
            return 'Password must contain at least one digit.';
        }

        return null;
    }
}
