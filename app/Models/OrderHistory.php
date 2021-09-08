<?php

namespace App\Models;

use App\Constants\AppConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperOrderHistory
 */
class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'order_history';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        if ($this->type_id == AppConstants::ORDER_STATUS_TYPE_PAYMENT){
            return $this->belongsTo(PaymentStatus::class,'status_id');
        }
        if ($this->type_id == AppConstants::ORDER_STATUS_TYPE_FULFILMENT){
            return $this->belongsTo(FulfillmentStatus::class,'status_id');
        }
        return $this->belongsTo(OrderStatus::class,'status_id');
    }
}
