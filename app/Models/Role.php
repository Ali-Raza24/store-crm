<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\GuardDoesNotMatch;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\RefreshesPermissionCache;

/**
 * @mixin IdeHelperRole
 */
class Role extends ModelsRole
{
    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'role_id');
    }

}
