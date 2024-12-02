<?php

declare(strict_types=1);

namespace App\AuthorizationContract\Enum;

enum DailyActivityPermission: string
{
    private const string PREFIX = 'daily_activity.';
    case Read = self::PREFIX . 'read';
    case Create = self::PREFIX . 'create';
    case List = self::PREFIX . 'list';
}
