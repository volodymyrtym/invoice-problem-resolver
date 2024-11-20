<?php

declare(strict_types=1);

namespace App\Common\Service;

final class ClockImpl implements Clock
{
    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
