<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFulfillmentStatus
 */
class FulfillmentStatus extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    public function newQuery() {
        return parent::newQuery()->where('type', '=', self::class)->where('title','!=', 'returned');
    }
}
