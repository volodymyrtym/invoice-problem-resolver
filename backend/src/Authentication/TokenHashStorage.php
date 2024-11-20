<?php

namespace App\Authentication;

interface TokenHashStorage
{
    public function save(string $hash, string $userId, int $ttlSeconds): void;

    public function find(string $hash): ?string;
}
