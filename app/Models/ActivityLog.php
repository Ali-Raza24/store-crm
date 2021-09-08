<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperActivityLog
 */
class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
