<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProductVariant
 */
class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    public function variantOptions(){
        return $this->hasMany(ProductVariantsOption::class, 'variant_id');
    }
}
