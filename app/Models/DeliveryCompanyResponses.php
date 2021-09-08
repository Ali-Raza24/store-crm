<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDeliveryCompanyResponses
 */
class DeliveryCompanyResponses extends Model
{
    use HasFactory;

    protected $table = 'delivery_company_responses';

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function delivery_company()
    {
        return $this->belongsTo(DeliveryCompany::class, 'delivery_company_id');
    }
}
