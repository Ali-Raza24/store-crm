<?php

namespace App\Models;

use App\Constants\IStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperBrand
 */
class Brand extends Model
{
    use HasFactory, LogsActivity;

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('M d, Y');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeActiveBusiness($q)
    {
        return $q->whereIsActive(IStatus::ACTIVE)
            ->whereBusinessId(\Auth::user()->business_id)
            ->whereNull('deleted_at');
    }
}
