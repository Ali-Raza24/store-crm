<?php

namespace App\Http\Requests;

use App\Rules\EscapeSpecial;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50', new EscapeSpecial()],
            'state_id' => 'required',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            'state_id.required' => 'The city field is required',
            'address.required' => 'The address is required field'
        ];
    }
}
