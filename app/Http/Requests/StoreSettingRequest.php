<?php

namespace App\Http\Requests;

use App\Models\Business;
use App\Models\Store;
use App\Rules\OnlyNumbers;
use App\Rules\UrlRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreSettingRequest extends FormRequest
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
                'stores.*.email' => [
                    'required',
                    'email:rfc,dns'
                ],
                'stores.*.phone' => ['nullable', 'digits_between:5,10', new OnlyNumbers()],
                'stores.*.mobile' => ['nullable', 'digits_between:10,15', new OnlyNumbers()],
                'stores.*.delivery_limit_km' => ['nullable', 'numeric', 'min:0'],
                'stores.*.state_id' => 'required',
            ];
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
