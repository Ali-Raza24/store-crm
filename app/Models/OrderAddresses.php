<?php

namespace App\Models;

use App\Constants\AppConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

/**
 * @mixin IdeHelperOrderAddresses
 */
class OrderAddresses extends Model
{
    use HasFactory;

    public function city()
    {
        if ($this->order->delivery_type == AppConstants::ARAMEX) {
            return $this->belongsTo(DeliveryCompaniesCity::class,'city_id','id')->where('delivery_company_id', '=', AppConstants::DELIVERY_COMPANY_ARAMEX);
        }
        return $this->belongsTo(State::class,'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getCityNameAttribute()
    {
        /**
         * @var $city State
         */
        $city = $this->city;
        if ($this->order->delivery_type == AppConstants::ARAMEX){
            /**
             * @var $city DeliveryCompaniesCity
             */
            $name =  optional(DeliveryCompaniesCity::find($this->city_id))->city_name;
            if (!$name) {
                return 'Dubai';
            }
            return $name;
        }
        return $city->name;
    }
}
