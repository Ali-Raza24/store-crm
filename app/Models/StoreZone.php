<?php

namespace App\Models;

use App\Constants\IStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperStoreZone
 */
class StoreZone extends Model
{
    use HasFactory;

    public function scopeActiveBusiness($q)
    {
        return $q->whereBusinessId(\Auth::user()->business_id)
            ->whereNull('deleted_at');
    }

    public function zoneArea(){
        return $this->hasMany(ZoneArea::class, 'zone_id','id');
    }
}
