<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperZoneArea
 */
class ZoneArea extends Model
{
    use HasFactory;

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function zone(){
        return $this->hasMany(StoreZone::class,'id','zone_id')->whereBusinessId(\Auth::user()->business_id);
    }
}
