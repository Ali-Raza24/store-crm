<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Image
 * @package App\Models
 * @property $id
 * @property $imageable_id
 * @property $imageable_type
 * @property $key
 * @property $url
 * @property $title
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @mixin IdeHelperImage
 */
class Image extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title', 'business_id', 'user_id', 'is_active'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getThumbnailAttribute($thumbnail)
    {
        if ($thumbnail) {
            return $thumbnail;
        } else {
            return $this->url;
        }
    }
}
