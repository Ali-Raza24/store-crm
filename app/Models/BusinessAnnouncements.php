<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBusinessAnnouncements
 */
class BusinessAnnouncements extends Model
{
    use HasFactory;

    protected $table = 'business_announcements';
}
