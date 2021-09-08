<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Image64Rule implements Rule
{
    private $allowedTypes = ['png', 'jpg', 'jpeg'];

    private $maxSize = 2048;

    private $minHeight = 400;

    private $maxHeight = 410;

    private $minWidth = 360;

    private $maxWidth = 370;

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
        $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
        if (in_array($type, $this->allowedTypes)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
