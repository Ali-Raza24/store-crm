<?php

namespace App\Models;

use App\Constants\IStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @mixin IdeHelperDiscount
 */
class Discount extends Model
{
    protected $attributes = ['is_active' => IStatus::DISCOUNT_ACTIVE];

    public function getMinimumAmountAttribute($val){
        return $val > 0 ? $val : null;
    }

    public function getMinimumQuantityAttribute($val){
        return $val > 0 ? $val : null;
    }
    public function business(): BelongsTo {
        return $this->belongsTo(Business::class);
    }
    public function products(): HasMany {
        return $this->hasMany(DiscountProduct::class,'discount_id');
    }

    public function discountLogs()
    {
        return $this->hasMany(DiscountLogs::class, 'discount_id');
    }

    public function getDiscountProductsAttribute()
    {
        $products = $this->products;
        $list = [];
        foreach ($products as $product){
            $list[] = $product->product->title;
        }
        return join(',', $list);
    }

    public function getDiscountDurationAttribute()
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $this->from_date)->format('M d');
        if (!empty($this->to_date)){
            $endDate = Carbon::createFromFormat('Y-m-d', $this->to_date)->format('M d');;
            return $startDate. " - ". $endDate;
        }else{
            return $startDate;
        }
    }

    public function getSumDiscountUsedAttribute()
    {
        return $this->discountLogs()->sum('amount');
    }

}
