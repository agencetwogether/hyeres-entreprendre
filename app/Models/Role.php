<?php

namespace App\Models;

use App\Enums\Role as RoleEnum;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected function casts(): array
    {
        return [
            'name' => RoleEnum::class,
        ];
    }
}
