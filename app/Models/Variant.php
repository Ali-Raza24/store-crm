<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperVariant
 */
class Variant extends Model
{
    use HasFactory;

    public function variant_options(){
        return $this->hasMany(VariantOptions::class,'variant_id');
    }
}
