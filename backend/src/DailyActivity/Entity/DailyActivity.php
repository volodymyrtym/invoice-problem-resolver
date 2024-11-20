<?php

declare(strict_types=1);

namespace App\DailyActivity\Entity;

use App\DailyActivity\Enum\ActivityEnum;
use App\DailyActivity\ValueObject\DailyActivityDescription;
use App\DailyActivity\ValueObject\DailyActivityId;
use App\User\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Index(name: 'user_idx', columns: ['user'])]
#[ORM\Index(name: 'user_date_idx', columns: ['user', 'from', 'to'])]
class DailyActivity
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 36, nullable: false)]
    private string $userId;

    #[ORM\Column(length: 10, nullable: false)]
    private string $type;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $from;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $to;

    #[ORM\Column(nullable: false)]
    private string $description;

    public function __construct(
        DailyActivityId $id,
        UserId $userId,
        ActivityEnum $type,
        \DateTimeImmutable $from,
        \DateTimeImmutable $to,
        DailyActivityDescription $description,
    ) {
        $this->id = $id->toString();
        $this->userId = $userId->toString();
        $this->type = $type->value;
        $this->from = $from;
        $this->to = $to;
        $this->description = $description->toString();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFrom(): \DateTimeImmutable
    {
        return $this->from;
    }

    public function getTo(): \DateTimeImmutable
    {
        return $this->to;
    }

    public function getDescription(): DailyActivityDescription
    {
        return new DailyActivityDescription($this->description);
    }
}
