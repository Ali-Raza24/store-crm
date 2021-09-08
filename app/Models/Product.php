<?php

namespace App\Models;

use App\Constants\IStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Str;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['title', 'description', 'slug', 'sku', 'cost_price', 'retail_price', 'discounted_price', 'barcode', 'is_active', 'has_addons_or_variants'];

    protected $attributes = [
        'is_active' => IStatus::ACTIVE,
        'has_addons_or_variants' => 0
    ];

    public function scopeActive($q)
    {
        return $q->whereBusinessId(\Auth::user()->business_id)->whereIsActive(IStatus::ACTIVE)->whereNull('deleted_at');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function stores()
    {
        return $this->hasMany(ProductStores::class);
    }

    public function getProductCategoryAttribute()
    {
        $categories = $this->categories()->get();
        $name = [];
        foreach ($categories as $category) {
            $name[] = $category->title;
        }
        return $name;
    }

    public function getProductStoresAttribute()
    {
        $stores = $this->stores()->get();
        $name = [];
        foreach ($stores as $store) {
            $name[] = $store->store->name;
        }
        return $name;
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function addons()
    {
        return $this->hasMany(ProductAddons::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariations::class, 'product_id');
    }

    public function getMainImageAttribute()
    {
        return optional($this->images()->where('key','=','main')->first())->url;
    }

    public function getMainImageObjAttribute()
    {
        return $this->images()->where('key','=','main')->first();
    }

    public function getOtherImagesAttribute()
    {
        return $this->images()->where('key','!=','main')->orderByRaw('`key` desc')->get();
    }

    public function getSlugAttribute($slug)
    {
        if (!$slug){
            return Str::slug($this->title);
        }
        return $slug;
    }
}
