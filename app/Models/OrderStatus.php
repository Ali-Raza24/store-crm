<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

/**
 * @mixin IdeHelperOrderStatuses
 * @mixin IdeHelperOrderStatus
 */
class OrderStatus extends Model
{
    use HasFactory;

}
