<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

/**
 * @mixin IdeHelperOrderDetail
 */
class OrderDetail extends Model
{
    use HasFactory;

    public function getPriceAttribute($price)
    {
        if (isset($price)){
            return round($price, 2);
        }
        return 0.00;
    }

    public function getDiscountValueAttribute($price)
    {
        if (isset($price)) {
            return round($price, 2);
        }
        return "0.00";
    }

    public function product(){
        return  $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariations::class, 'product_variation_id');
    }
}
