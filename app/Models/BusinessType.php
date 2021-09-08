<?php

namespace App\Models;

use App\Constants\IStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperBusinessType
 */
class BusinessType extends Model
{
    use HasFactory, LogsActivity;

    protected $attributes = ['is_active' => IStatus::ACTIVE];

    public static function scopeActive($q){
        return $q->whereIsActive(IStatus::ACTIVE)->whereNull('deleted_at')->get();
    }
}
