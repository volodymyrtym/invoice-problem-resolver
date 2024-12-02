<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Create;

use App\Common\Exception\InvalidInputException;
use App\DailyActivity\Entity\DailyActivity;
use App\DailyActivity\Enum\ActivityTypeEnum;
use App\DailyActivity\ValueObject\DailyActivityDateRange;
use App\DailyActivity\ValueObject\DailyActivityDescription;
use App\DailyActivity\ValueObject\DailyActivityId;
use App\UserContract\ValueObject\UserId;
use Psr\Clock\ClockInterface;

final readonly class CreateHandler
{
    public function __construct(
        private int $maxPerDay,
        private DailyActivityCreateRepository $repository,
        private ClockInterface $clock,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function handle(CreateCommand $command): string
    {
        $id = DailyActivityId::create();
        $userId = UserId::fromString($command->userId);
        $range = new DailyActivityDateRange(
            start: $command->start,
            end: $command->end,
        );

        if ($this->repository->countToday($userId) > $this->maxPerDay) {
            throw new InvalidInputException('Maximum allowed activities per day reached. Max: ' . $this->maxPerDay);
        }

        $this->repository->save(
            new DailyActivity(
                id: $id,
                userId: UserId::fromString($command->userId),
                range: $range,
                description: new DailyActivityDescription($command->description),
                createdAt: $this->clock->now(),
            ),
        );

        return $id->toString();
    }
}
