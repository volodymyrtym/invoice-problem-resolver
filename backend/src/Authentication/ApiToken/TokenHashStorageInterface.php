<?php

declare(strict_types=1);

namespace App\Authentication\ApiToken;

interface TokenHashStorageInterface
{
    public function save(string $hash, string $userId, int $ttlSeconds): void;

    public function findUserId(string $tokenHash): ?string;
}
