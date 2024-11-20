<?php

namespace App\Authentication;

class RedisTokenHashStorage implements TokenHashStorage
{
    public function save(string $hash, string $userId, int $ttlSeconds): void
    {
        // TODO: Implement save() method.
    }

    public function find(string $hash): ?string
    {
        // TODO: Implement find() method.
    }
}
