<?php

declare(strict_types=1);

namespace App\DailyActivity\Entity;

use App\DailyActivity\Enum\ActivityTypeEnum;
use App\DailyActivity\ValueObject\DailyActivityDateRange;
use App\DailyActivity\ValueObject\DailyActivityDescription;
use App\DailyActivity\ValueObject\DailyActivityId;
use App\UserContract\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'daily_activity_daily_activities')]
#[ORM\Index(name: 'user_start_date_idx', columns: ['user_id', 'start_at'])]
#[ORM\Index(name: 'user_created_at', columns: ['user_id', 'created_at'])]
class DailyActivity
{
    #[ORM\Id]
    #[ORM\Column(type: "string", unique: true)]
    private string $id;

    #[ORM\Column(length: 36, nullable: false)]
    private string $userId;

    #[ORM\Column(length: 10, nullable: false)]
    private string $type;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $startAt;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $endAt;

    #[ORM\Column(nullable: false)]
    private string $description;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        DailyActivityId $id,
        UserId $userId,
        ActivityTypeEnum $type,
        DailyActivityDateRange $range,
        DailyActivityDescription $description,
        \DateTimeImmutable $createdAt,
    ) {
        $this->id = $id->toString();
        $this->userId = $userId->toString();
        $this->type = $type->value;
        $this->startAt = $range->start;
        $this->endAt = $range->end;
        $this->description = $description->toString();
        $this->createdAt = $createdAt;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStartAt(): \DateTimeImmutable
    {
        return $this->startAt;
    }

    public function getEndAt(): \DateTimeImmutable
    {
        return $this->endAt;
    }

    public function getDescription(): DailyActivityDescription
    {
        return new DailyActivityDescription($this->description);
    }
}
