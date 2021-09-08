<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property $id
 * @property $name
 * @property $first_name
 * @property $last_name
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $business_id
 * @property $remember_token
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at

 * @mixin IdeHelperCustomer
 */
class Customer extends Authenticatable
{
    use HasFactory;

    /*public function getNameAttribute()
    {
        return $this->first_name. ' '. $this->last_name;
    }*/

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function getOrderCountAttribute()
    {
        return $this->orders->count('id');
    }

    public function getAmountSpentAttribute()
    {
        $amount = $this->orders->sum('total');
        return number_format($amount,2);
    }

    public function getImageAttribute()
    {
        return optional($this->images()->first())->url;
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
