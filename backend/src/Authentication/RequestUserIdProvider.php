<?php

declare(strict_types=1);

namespace App\Authentication;

interface RequestUserIdProvider
{
    public function getUserOrDennyRequest(): string;
}
