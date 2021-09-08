<?php

namespace App\Models;

use App\Constants\IStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperArea
 */
class Area extends Model
{
    use HasFactory;

    protected $attributes = ['is_active' => IStatus::ACTIVE];

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function zone(){
        return $this->hasMany(ZoneArea::class, 'area_id','id');
    }

    public function business()
    {
        return $this->hasMany(BusinessArea::class, 'area_id', 'id');
    }
}
