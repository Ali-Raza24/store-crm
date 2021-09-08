<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumHyphenSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddBrand extends FormRequest
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
            'title' => [
                'required',
                new AlphaNumHyphenSpace(),
                Rule::unique('brands', 'title')->ignore($this->request->get('id'))->where('business_id', Auth::user()->business_id)
            ],
            'is_active' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Enter Brand name!',
            'is_active.required' => 'Select status!',
            'title.unique' => 'Brand name already exists',
            'title.regex' => 'Only alphabets are allowed'
        ];
    }
}
