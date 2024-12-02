<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

final readonly class GetListQuery
{
    public function __construct(public int $page, public int $limit, public string $userId) {}
}
