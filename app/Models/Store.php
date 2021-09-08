<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Store
 * @package App\Models
 * @property $id
 * @property $business_id
 * @property $name
 * @property $email
 * @property $phone
 * @property $mobile
 * @property $url
 * @property $address_1
 * @property $address_2
 * @property $opening_time
 * @property $closing_time
 * @property $delivery_limit_km
 * @property $is_own_delivery
 * @property $delivery_company_id
 * @property $latitude
 * @property $longitude
 * @property $industry_id
 * @property $state_id
 * @property $country_id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @mixin IdeHelperStore
 */

class Store extends Model
{
    use HasFactory;

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
