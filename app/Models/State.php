<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperState
 */
class State extends Model
{
    use HasFactory, LogsActivity;
}
