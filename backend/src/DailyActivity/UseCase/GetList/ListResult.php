<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

final readonly class ListResult
{
    public array $items;

    public function __construct(public bool $hasPrevPage, public bool $hasNexPage, ListItem ...$items)
    {
        $this->items = $items;
    }
}
