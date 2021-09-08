<?php

namespace App\Models;

use App\Constants\IStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('M d, Y');
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeActiveBusiness($q)
    {
        return $q->whereIsActive(IStatus::ACTIVE)
            ->whereBusinessId(\Auth::user()->business_id)
            ->whereNull('deleted_at');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, ProductCategories::class,'category_id','id','id','product_id');
    }

    public function getSlugAttribute($slug)
    {
        if (!$slug){
            return Str::slug($this->title);
        }
        return $slug;
    }
}
