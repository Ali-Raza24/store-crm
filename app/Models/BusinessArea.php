<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBusinessArea
 */
class BusinessArea extends Model
{
    use HasFactory;

    public function area(){
        return $this->belongsTo(Area::class);
    }

    /*public function zone(){
        return $this->hasManyThrough(StoreZone::class, ZoneArea::class,'zone_id','id','area_id','zone_id')
            ->whereBusinessId(\Auth::user()->business_id);
    }*/

    public function zone()
    {
        return $this->hasMany(ZoneArea::class,'area_id','area_id');
    }
}
