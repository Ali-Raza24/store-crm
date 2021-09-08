<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProductVariantsOption
 */
class ProductVariantsOption extends Model
{
    use HasFactory;

    protected $table = 'product_variants_options';

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id','id');
    }

    public function options()
    {
        return $this->hasMany(ProductVariantOptions::class, 'variant_option_id','id');
    }
}
