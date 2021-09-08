<?php

namespace App\Models;

use App\Constants\IStatus;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyBusiness;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Traits\HasRoles;
use Yadahan\AuthenticationLog\AuthenticationLogable;

/**
 * Class User
 * @package App\Models
 * @property $id
 * @property $name
 * @property $username
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $user_type_id
 * @property $is_business
 * @property $business_id
 * @property $location_id
 * @property $remember_token
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property-read Business $business
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = ['is_active' => IStatus::ACTIVE,'is_business' => 0];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyBusiness());
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, $this));
    }

    public function role()
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            'role_id'
        );
    }

    public function images(){
        return $this->morphOne(Image::class,'imageable');
    }

    public function getProfileAttribute(){
        return optional($this->images()->first())->url;
    }

    public function getProfileThumbAttribute(){
        return asset("thumbnails/users/".optional($this->images()->first())->thumbnail);
    }

    public function details()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /*public function notifyAuthenticationLogVia()
    {
        return ['mail'];
    }*/

    public function hasAnyPermission(...$permissions): bool
    {
        $permissions = collect($permissions);

        if(is_array(\Arr::first($permissions))) {
            foreach (\Arr::first($permissions) as $permission) {
                if ($this->checkPermissionTo($permission)) {
                    return true;
                }
            }
        }else{
            if ($this->checkPermissionTo(\Arr::first($permissions))) {
                return true;
            }
        }

        return false;
    }

    public function checkPermissionTo($permission, $guardName = null): bool
    {
        try {
            return $this->hasPermissionTo($permission, $guardName);
        } catch (PermissionDoesNotExist $e) {
            return false;
        }
    }

    public function hasPermissionTo($permission, $guardName = null): bool
    {
        if (config('permission.enable_wildcard_permission', false)) {
            return $this->hasWildcardPermission($permission, $guardName);
        }

        $permissionClass = $this->getPermissionClass();
        if (is_array($permission)){
            $permission = PermissionModel::where(['name' => $permission['name'], 'is_business' => $permission['is_business']])->first();
        }

        if (is_string($permission)) {
            $permission = $permissionClass->findByName(
                $permission,
                $guardName ?? $this->getDefaultGuardName()
            );
        }

        if (is_int($permission)) {
            $permission = $permissionClass->findById(
                $permission,
                $guardName ?? $this->getDefaultGuardName()
            );
        }

        if (! $permission instanceof Permission) {
            throw new PermissionDoesNotExist;
        }

        return $this->hasDirectPermission($permission) || $this->hasPermissionViaRole($permission);
    }
}
