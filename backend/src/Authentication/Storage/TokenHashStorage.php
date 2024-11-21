<?php

namespace App\Authentication\Storage;

interface TokenHashStorage
{
    public function save(string $hash, string $userId, int $ttlSeconds): void;

    public function findUserId(string $tokenHash): ?string;
}
