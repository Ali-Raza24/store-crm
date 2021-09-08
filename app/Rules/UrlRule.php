<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UrlRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       return preg_match('/^[_a-z0-9](?!.*?[^\na-z0-9-_]).*?[a-z0-9_]$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The url field should only allow small letters, digits and hyphen. Hyphen not allowed at start';
    }
}
