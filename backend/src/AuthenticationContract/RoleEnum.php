<?php

declare(strict_types=1);

namespace App\AuthenticationContract;

enum RoleEnum: string
{
    case User = 'ROLE_USER';
    case Admin = 'ROLE_ADMIN';
}
