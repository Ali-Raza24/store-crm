<?php

namespace App\Http\Requests;

use App\Rules\FbCheckRule;
use App\Rules\InstaCheckRule;
use App\Rules\LinkedInUrlCheckRule;
use App\Rules\OnlyNumbers;
use App\Rules\TwitterUrlCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyInformationRequest extends FormRequest
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
        $extraRules = [];
        $rules = [
            'name' => 'required',
            'details.mobile' => ['nullable', new OnlyNumbers(), 'min:10', 'max:15'],
            'details.phone' => ['nullable', new OnlyNumbers(), 'min:5', 'max:10'],
        ];
        if (!empty(\request('social'))){
            $social = \request('social');
            if (!empty($social['facebook'])){
                $extraRules = array_merge($extraRules,['social.facebook' => new FbCheckRule()]);
            }
            if (!empty($social['linkedin'])){
                $extraRules = array_merge($extraRules,['social.linkedin' => new LinkedInUrlCheckRule()]);
            }
            if (!empty($social['twitter'])){
                $extraRules = array_merge($extraRules,['social.twitter' => new TwitterUrlCheckRule()]);
            }
            if (!empty($social['instagram'])){
                $extraRules = array_merge($extraRules,['social.instagram' => new InstaCheckRule()]);
            }
        }
        return array_merge($rules, $extraRules);
    }
    public function messages()
    {
        return [
            'details.mobile.min' => 'The mobile number must be between 10 to 15 digits',
            'details.mobile.max' => 'The mobile number must be between 10 to 15 digits',
            'details.phone.min' => 'The phone number must be between 5 to 10 digits',
            'details.phone.max' => 'The phone number must be between 5 to 10 digits',
        ];
    }
}
