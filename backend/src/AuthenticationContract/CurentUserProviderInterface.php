<?php

declare(strict_types=1);

namespace App\AuthenticationContract;

interface CurentUserProviderInterface
{
    public function provideId(): string;
}
