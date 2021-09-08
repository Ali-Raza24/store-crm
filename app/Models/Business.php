<?php

namespace App\Models;

use App\Constants\IStatus;
use App\Helpers\CommonHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Laravel\Cashier\Billable;

/**
 * Class Business
 * @package App\Models
 * @property $id
 * @property $code
 * @property $name
 * @property $email
 * @property $phone
 * @property $mobile
 * @property $owner_name
 * @property $owner_email
 * @property $owner_phone
 * @property $owner_mobile
 * @property $brand_color
 * @property $total_stores
 * @property $minimum_order_amount
 * @property $business_type_id
 * @property $url
 * @property $plan_id
 * @property $business_status_id
 * @property $address_1
 * @property $address_2
 * @property $country_id
 * @property $state_id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property-read Store $stores
 * @mixin IdeHelperBusiness
 */
class Business extends Model
{
    use HasFactory, SoftDeletes, Billable;

    protected $table = 'businesses';

    public function getCreatedAtAttribute($date)
    {
        return Carbon::rawParse($date)->format('M d, Y');
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, 'business_id');
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getEidAttribute()
    {
        return optional($this->images()->where(['key' => 'eid'])->latest()->first())->url;
    }

    public function getTradeAttribute()
    {
        return optional($this->images()->where(['key' => 'trade'])->latest()->first())->url;
    }

    public function getLogoAttribute()
    {
        return optional($this->images()->where(['key' => 'logo'])->latest()->first())->url;
    }

    public function getLogoMobileAttribute()
    {
        return optional($this->images()->where(['key' => 'logo_mobile'])->latest()->first())->url;
    }

    public function getProfileAttribute()
    {
        return optional($this->images()->where(['key' => 'profile'])->latest()->first())->url;
    }

    public function businessZones()
    {
        return $this->hasMany(StoreZone::class, 'business_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'business_id', 'id')->where('email', '=', $this->owner_email);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function getPlanNameAttribute()
    {
        $plan = $this->plan;
        if ($plan){
            return $plan->title;
        }
        return '';
    }

    public function getBusinessStatusAttribute()
    {
        $businessStatus = Status::whereIsActive(IStatus::ACTIVE)->where(['type' => Business::class])->get()->pluck('title',
            'id');
        $status = Arr::get($businessStatus, $this->business_status_id);
        if ($status) {
            return $status;
        } else {
            return 'Pending';
        }
    }

    public function staff()
    {
        return $this->hasMany(User::class,'business_id');
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function subscribe()
    {
        return $this->hasOne(Subscriber::class, 'email', 'email');
    }

    public function getIsSubscribedAttribute()
    {
        $subscribe = $this->subscribe()->first();
        if ($subscribe){
            return true;
        }
        return false;
    }
}
