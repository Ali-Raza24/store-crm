<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Permission;

/**
 * @mixin IdeHelperPermissionModel
 */
class PermissionModel extends Permission
{
    use HasFactory;

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);

        $permission = static::getPermissions(['name' => $attributes['name'], 'guard_name' => $attributes['guard_name'], 'is_business', $attributes['is_business'], 'group' => $attributes['group']])->first();

        if ($permission) {
            throw PermissionAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }
}
