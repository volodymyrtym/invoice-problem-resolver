<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Add;

use App\Common\Exception\InvalidInputException;
use App\DailyActivity\Entity\DailyActivity;
use App\DailyActivity\Enum\ActivityEnum;
use App\DailyActivity\Repository\DailyActivityRepositoryInterface;
use App\DailyActivity\ValueObject\DailyActivityDescription;
use App\DailyActivity\ValueObject\DailyActivityId;
use App\UserContract\ValueObject\UserId;

final readonly class AddHandler
{
    public function __construct(private DailyActivityRepositoryInterface $repository) {}

    /**
     * @throws InvalidInputException
     */
    public function handle(AddCommand $command): string
    {
        $type = ActivityEnum::tryFrom($command->type) ?? throw InvalidInputException::forField($command->type);
        $id = DailyActivityId::create();
        $this->repository->save(
            new DailyActivity(
                id: $id,
                userId: UserId::fromString($command->userId),
                type: $type,
                from: $command->from,
                to: $command->to,
                description: new DailyActivityDescription($command->description),
            ),
        );

        return $id->toString();
    }
}
