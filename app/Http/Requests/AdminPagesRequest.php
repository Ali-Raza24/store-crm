<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPagesRequest extends FormRequest
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
            'content.page.name' => 'required',
            'content.page.title' => 'required',
            'content.banner.title' => 'required',
            'content.banner.btn_title' => 'required',
            'content.banner.banner_btn_link' => 'required',
            'content.ecommerce.heading' => 'required',
            'content.ecommerce.content' => 'required',
            'content.ecommerce.btn_title' => 'required',
            'content.ecommerce.btn_link' => 'required',
            'content.ecommerce.video_link' => 'required',
            'content.pricing.content' => 'required',
            'content.request.content' => 'required',
            'content.information.content' => 'required',
            'content.information.heading' => 'required',
            'content.service.heading' => 'required',
            'images.*' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:5096',
        ];
    }
    public function messages()
    {
        return [
            'content.page.name.required' => 'Enter page Name!',
            'content.page.title.required' => 'Enter page code!',
            'content.banner.btn_title' => 'Enter Button Title',
            'content.banner.banner_btn_link' => 'Enter banner button link',
            'content.ecommerce.heading' => 'Enter heading',
            'content.service.heading' => 'Enter heading',
            'content.ecommerce.content' => 'Enter Content',
            'content.ecommerce.btn_title' => 'Enter button title',
            'content.ecommerce.btn_link' => 'Enter button link',
            'content.ecommerce.video_link' => 'Enter video link',
            'content.pricing.content' => 'Enter Pricing section content',
            'content.request.content' => 'Enter Request section content',
            'content.information.content' => 'Enter Contact Section content',
            'content.information.heading' => 'Enter heading',
            'images*'=>'Add image',
            'mimes' => 'Please Upload image only',
            'max'   => 'Image should be less than 5 MB'

        ];
    }
}
