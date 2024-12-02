<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList\Repository;

final readonly class RepositoryQueryResult
{
    public array $items;

    public function __construct(public bool $hasPrevPage, public bool $hasNexPage, RepositoryDailyActivityItem ...$items)
    {
        $this->items = $items;
    }
}
