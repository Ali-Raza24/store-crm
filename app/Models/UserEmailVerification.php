<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUserEmailVerification
 */
class UserEmailVerification extends Model
{
    use HasFactory;

    protected $table = 'user_email_verification';
}
