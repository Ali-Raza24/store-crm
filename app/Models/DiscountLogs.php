<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDiscountLogs
 */
class DiscountLogs extends Model
{
    use HasFactory;

    public function discount(){
        return $this->belongsTo(Discount::Class, 'discount_id');
    }
}
