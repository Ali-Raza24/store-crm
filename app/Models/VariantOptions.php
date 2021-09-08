<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperVariantOptions
 */
class VariantOptions extends Model
{
    use HasFactory;

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
