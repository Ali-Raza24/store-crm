<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPaymentStatuses
 * @mixin IdeHelperPaymentStatus
 */
class PaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    public function newQuery() {
        return parent::newQuery()->where('type', '=', self::class);
    }
}
