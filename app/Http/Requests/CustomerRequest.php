<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaces;
use App\Rules\OnlyNumbers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required', new AlphaSpaces()],
            'last_name' => ['required', new AlphaSpaces()],
            'phone' => ['required', new OnlyNumbers(), 'digits_between:10,15'],
            'zip' => ['required'],
            'discount' => ['nullable', 'numeric']
        ];
        if (empty(\request('customer_id'))){
            $rules = array_merge($rules, [  'email' => ['required', 'unique:customers', 'email:rfc,dns']]);
        }
        return $rules;
    }

    public function messages()
    {
        return [
          'zip.required' => 'The P.O code field is required',
        ];
    }
}
