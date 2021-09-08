<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUserPhoneNumberVerification
 */
class UserPhoneNumberVerification extends Model
{
    use HasFactory;

    protected $table = 'user_phone_number_verification';
}
