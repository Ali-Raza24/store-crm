<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumHyphenSpace implements Rule
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
        return preg_match('/^[0-9A-Za-z\s\-]+$/',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute may contain only Alphabets, Numbers, Hyphen and Space.';
    }
}
