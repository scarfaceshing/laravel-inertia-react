<?php

declare(strict_types=1);

namespace App\Utilities;

class Middleware
{
    public static function extractPermissions(string $type, array $permissions = []): string
    {
        $permissions = implode(',', $permissions);

        return $type.':'.$permissions;
    }
}
