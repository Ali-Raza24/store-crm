<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProductAddons
 */
class ProductAddons extends Model
{
    use HasFactory;

    public function addons(){
        return $this->belongsTo(Addon::class,'addon_id','id');
    }
}
