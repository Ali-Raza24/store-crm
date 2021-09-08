<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumHyphenSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddonRequests extends FormRequest
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
            'price' => 'required',
            'is_active' => 'required',
            'title' => [
                'required',
                new AlphaNumHyphenSpace(),
                Rule::unique('addons', 'title')->ignore($this->request->get('id'))->where('business_id', \Auth::user()->business_id)
            ]
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Enter Addon name!',
            'is_active.required' => 'Enter Status!',
            'price.required' => 'Enter Price!',
            'title.unique' => 'Addon name already exists',
            'title.regex' => 'Only alphabets are allowed'
        ];
    }
}
