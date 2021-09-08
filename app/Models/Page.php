<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
/**
 * @mixin IdeHelperPage
 */
class Page extends Model
{
    use HasFactory;

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getBannerAttribute(){
        return optional($this->image()->where(['key' => 'banner'])->first())->url;
    }

    public function getServiceAttribute(){
        return optional($this->image()->where(['key' => 'service'])->first())->url;
    }

    public function getWebBannerAttribute()
    {
        return optional($this->image()->where(['key' => 'web_banner'])->first())->url;
    }

    public function getMobileBannerAttribute()
    {
        return optional($this->image()->where(['key' => 'mobile_banner'])->first())->url;
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
