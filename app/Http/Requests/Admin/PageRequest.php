<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
            'page_name' => 'required',
            'page_title' => 'required',
            'meta_description'=> 'required',
            'page_heading'=> 'required',


        ];

    }
    public function messages()
    {
        return [
            'page_name.required' => 'Enter page Name!',
            'slug.required' => 'Enter page code!',
            'slug.unique' => 'page code already exists',
            'page_title.required' => 'Enter title Name!',
            'meta_description.required' => 'Enter description!',
            'page_heading.required' => 'Enter heading'

        ];
    }
}
