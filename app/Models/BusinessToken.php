<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBusinessToken
 */
class BusinessToken extends Model
{
    protected $table = 'business_tokens';

    public function business(){
        return $this->belongsTo(Business::class);
    }
}
