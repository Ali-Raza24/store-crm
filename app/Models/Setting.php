<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSetting
 */
class Setting extends Model
{
    use HasFactory;

    public static function getVal($key)
    {
        $data = self::where('key', $key);
        if ($key != 'tax') {
            $data = $data->where('business_id', \Auth::user()->business_id);
        }
        return $data->first();
    }
}
