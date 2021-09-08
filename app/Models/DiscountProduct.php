<?php

namespace App\Models;

use App\Constants\IStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDiscountProduct
 */
class DiscountProduct extends Model
{
    use SoftDeletes;

    public function discount(): BelongsTo {
        return $this->belongsTo(Discount::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
