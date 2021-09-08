<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyNumbers implements Rule
{
    private $fieldName;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($fieldName = '')
    {
        $this->fieldName = $fieldName;
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
        return preg_match('/^[0-9]*$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (empty($this->fieldName)){
            return 'The :attribute may only contain digits.';
        }
        else{
            return 'The '.$this->fieldName.' may only contain digits.';
        }
    }
}
