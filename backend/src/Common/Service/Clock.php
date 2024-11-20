<?php

namespace App\Common\Service;

interface Clock
{
    public function now(): \DateTimeImmutable;
}
