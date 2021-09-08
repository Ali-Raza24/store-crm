<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FbCheckRule implements Rule
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
        $fbUrlCheck = '/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';
        $secondCheck = '/home((\/)?\.[a-zA-Z0-9])?/';

        return preg_match($fbUrlCheck, $value) == 1 && preg_match($secondCheck, $value) == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please provide a valid facebook profile url';
    }
}
