<?php

/**
 * @param string $url
 * @param Config $url
 * @returns string
 */
if (!function_exists('api_url')) {
    function api_url($url): string
    {
        return url('/') . config('urls.' . $url);
    }
}

if (!function_exists('asset_timestamp')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function asset_timestamp($path)
    {
        return app('url')->asset($path . '?v=' . time());
    }
}

if (!function_exists('setting')) {
    function setting($key, $value = false)
    {
        if (!$value) {
            // Getter
            if (\App\Models\Setting::getVal($key)) {
                $val = \App\Models\Setting::getVal($key)->value;
                if (is_array($val)) {
                    return $val[0];
                }
                return $val;
            }
            return false;
        }
    }
}

if (!function_exists('check_setting')) {
    function check_setting($key, $value, $zero = null)
    {
        $setting = json_decode(setting($key));

        if (!empty($setting->{$value}) && ($value == 'tax_value' || in_array($key, ['order', 'invoice', 'tax','pixel']))){
            return $setting->{$value};
        }

        if (!empty($setting->{$value}) || (isset($setting->{$value}) && $setting->{$value} == $zero)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('format_number')) {
    function format_number($value, $decimal_point = 2)
    {
        $value = number_format($value, $decimal_point, '.', "");
        return round($value, 2, PHP_ROUND_HALF_EVEN);
    }
}

if (!function_exists('permission_map')) {
    function permission_map($permission, $key)
    {
        if (strpos($permission->name, $key . '-') !== false) {
            return true;
        }
        return false;
    }
}

if (!function_exists('plan_permission')) {
    function plan_permission($permission)
    {
        if (\Auth::user()->hasRole('Super Admin')) {
            return true;
        }
        if (\Auth::user()->hasAnyPermission([
                ['name' => $permission . '-list', 'is_business' => 1],
                ['name' => $permission . '-create', 'is_business' => 1],
                ['name' => $permission . '-edit', 'is_business' => 1],
                ['name' => $permission . '-delete', 'is_business' => 1],
                ['name' => $permission . '-show', 'is_business' => 1]
            ]
        )) {
            return true;
        }
        return false;
    }
}

if (!function_exists('plan_has_permission')) {
    function plan_has_permission($permission)
    {
        if (\Auth::user()->hasRole('Super Admin')) {
            return true;
        }
        if (is_string($permission)) {
            if (\Auth::user()->hasAnyPermission(['name' => $permission, 'is_business' => 1])) {
                return true;
            }
        }
        if (is_array($permission)) {
            $list = [];
            foreach ($permission as $item) {
                $list[] = ['name' => $item, 'is_business' => 1];
            }

            if (\Auth::user()->hasAnyPermission($list)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('currency_format')) {
    function currency_format($amount, $currency = 'AED') {
        return $currency.' '.format_number($amount);
    }
}
