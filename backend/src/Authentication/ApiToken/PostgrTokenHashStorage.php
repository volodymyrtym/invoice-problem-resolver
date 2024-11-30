<?php

declare(strict_types=1);

namespace App\Authentication\ApiToken;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Clock\ClockInterface;

/**
 * todo change to redis
 */
class PostgrTokenHashStorage implements TokenHashStorageInterface
{
    public function __construct(private EntityManagerInterface $entityManager, private ClockInterface $clock) {}

    public function save(string $hash, string $userId, int $ttlSeconds): void
    {
        $expireAt = $this->clock->now()->modify('+' . $ttlSeconds . ' seconds');

        $sql = <<<SQL
INSERT INTO authentication_tokens (hash, user_id, expire_at)
VALUES (:hash, :userId, :expireAt)
ON CONFLICT (user_id)
DO UPDATE SET
    hash = EXCLUDED.hash,
    expire_at = EXCLUDED.expire_at
SQL;
        $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'hash' => $hash,
                'userId' => $userId,
                'expireAt' => $expireAt->format('Y-m-d H:i:s'),
            ],
        );
    }

    public function findUserId(string $tokenHash): ?string
    {
        $sql = 'SELECT user_id FROM authentication_tokens WHERE hash = :hash AND expire_at > NOW() LIMIT 1';
        $result = $this->entityManager->getConnection()->executeQuery($sql, ['hash' => $tokenHash])->fetchAssociative();

        return empty($result) ? null : $result['user_id'];
    }
}
