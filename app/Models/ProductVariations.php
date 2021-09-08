<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProductVariations
 */
class ProductVariations extends Model
{
    use HasFactory;

    protected $table = 'product_variations';

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
