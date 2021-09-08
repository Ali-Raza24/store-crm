<?php

namespace App\Http\Requests;

use App\Models\Business;
use App\Models\Store;
use App\Rules\AlphaSpaces;
use App\Rules\FbCheckRule;
use App\Rules\InstaCheckRule;
use App\Rules\LinkedInUrlCheckRule;
use App\Rules\OnlyNumbers;
use App\Rules\TwitterUrlCheckRule;
use App\Rules\UrlRule;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        $rules = [];
        $extraRules = [];
        if ($this->getMethod() == Request::METHOD_PUT || $this->getMethod() == Request::METHOD_POST) {
            $rules = [
                'user.name' => ['required', new AlphaSpaces()],
                'owner_name' => ['required', new AlphaSpaces()],
                'owner_email' => ['required', 'email:rfc,dns'],
                'owner_phone' => ['nullable', 'digits_between:5,10', new OnlyNumbers()],
                'owner_mobile' => ['required', 'digits_between:10,15', new OnlyNumbers()],
                'name' => ['required', new AlphaSpaces()],
                'email' => ['required', 'email:rfc,dns'],
                'phone' => ['nullable', 'digits_between:5,10', new OnlyNumbers()],
                'mobile' => ['required', 'digits_between:10,15', new OnlyNumbers()],
                'old_password' => ['nullable', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, \Auth::user()->password)) {
                        $fail("Old password doesn't match");
                    }
                }],
                'new_password' => [Rule::requiredIf(function (){return !empty(\request('old_password'));}),
                    function ($attribute, $value, $fail) {
                        if(!empty(\request('old_password'))) {
                            if ($value == \request('old_password')) {
                                $fail("The new password and old password must be different");
                            }
                        }
                    }
                    ],
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
            $bank = \request('bank');
            if (!empty($bank['bank_name']) || !empty($bank['branch']) || !empty($bank['account_title']) || !empty($bank['account_number']) || !empty($bank['iban']) || !empty($bank['swift_code'])){
                $extraRules = array_merge($extraRules, [
                    'bank.bank_name' => 'required',
                    'bank.branch' => ['required'],
                    'bank.account_title' => ['required'],
                    'bank.account_number' => ['required', new OnlyNumbers()],
                    'bank.iban' => ['required'],
                    'bank.swift_code' => ['required'],
                ]);
            }
        }
        return array_merge($rules, $extraRules);
    }

    public function messages()
    {
        $parent = parent::messages();
        $messages = [
            'stores.*.name.required' => 'The store name field is required',
            'stores.*.email.required' => 'The store email field is required',
            'stores.*.email.email' => 'The store email must be valid email address',
            'stores.*.email.unique' => 'The store email has already been taken',
            'stores.*.phone.required' => 'The store phone field is required',
            'stores.*.mobile.required' => 'The store mobile field is required',
            'stores.*.phone.digits_between' => 'The store phone field must be numbers and length between is 5 to 10 digits',
            'stores.*.mobile.digits_between' => 'The store mobile field must be numbers and length between is 10 to 15 digits',
            'stores.*.state_id.required' => 'The store city field is required',
        ];

        return array_merge($messages, $parent);
    }
}
