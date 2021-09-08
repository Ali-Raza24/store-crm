<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductImagesRequest extends FormRequest
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
            'images.*' => [Rule::dimensions()->minWidth(360)->minHeight(400), 'image', 'mimes:jpg,png,gif,jpeg']
        ];
    }

    public function messages()
    {
        return [
            'images.*.dimensions' => 'Please upload image of resolution minimum 360(w) X 400(h)'
        ];
    }
}
