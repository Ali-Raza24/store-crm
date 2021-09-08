<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestimonialRequest extends FormRequest
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
            'testimonial_name' => 'required',
            'testimonial_message' => 'required',
            'testimonial_status' => 'required',
            'images.*' => ['max:2000','mimes:png,jpeg',Rule::dimensions()->minWidth(70)->minHeight(70)],
        ];
    }

    public function messages()
    {
        return [
          'images.*.max' => 'The max image size is 2MB',
          'images.*.mimes' => 'The PNG,JPG file types are allowed',
          'images.*.dimensions' => 'The minimum file dimenesions are 70 x 70',
        ];
    }
}
