<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDeliveryCompanyArea
 */
class DeliveryCompanyArea extends Model
{
    use HasFactory;

    protected $table = 'delivery_companies_areas';
}
