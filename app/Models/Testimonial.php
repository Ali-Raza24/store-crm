<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperTestimonial
 */
class Testimonial extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'testimonials';

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('M d, Y');
    }
}
