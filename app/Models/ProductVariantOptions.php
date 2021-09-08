<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProductVariantOptions
 */
class ProductVariantOptions extends Model
{
    protected $table = 'product_variant_options';

    public function options()
    {
        return $this->belongsTo(VariantOptions::class, 'variant_option_id','id');
    }
}
