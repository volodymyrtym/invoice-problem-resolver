<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList\Repository;

use App\DailyActivity\UseCase\GetList\DailyActivityViewItem;

final readonly class RepositoryQueryResult
{
    public array $items;

    public function __construct(public bool $hasPrevPage, public bool $hasNexPage, DailyActivityViewItem ...$items)
    {
        $this->items = $items;
    }
}
