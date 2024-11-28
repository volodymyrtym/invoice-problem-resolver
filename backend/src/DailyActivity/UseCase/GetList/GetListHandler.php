<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

use App\DailyActivity\UseCase\GetList\Repository\GetListRepository;

class GetListHandler
{
    public function __construct(
        private GetListRepository $repository,
        private ByDateGrouper $byDateGrouper,
    ) {}

    public function handle(GetListQuery $query): GetListResult
    {
        $activities = $this->repository->getList($query);
        $activitiyGroupedByDate = $this->byDateGrouper->group(...$activities->items);

        return new GetListResult($activities->hasPrevPage, $activities->hasNexPage, ...$activitiyGroupedByDate);
    }
}
