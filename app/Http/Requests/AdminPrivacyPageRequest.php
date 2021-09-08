<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPrivacyPageRequest extends FormRequest
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
            'title' => 'required',
            'name' => 'required',
            'page_heading' => 'required',
            'meta_discription' => 'required',
            'content' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Enter page Name!',
            'title.required' => 'Enter page Title!',
            'page_heading' => 'Enter Button page heading',
            'meta_discription' => 'Enter meta description',
            'content' => 'Enter Content',
        ];
    }
}
