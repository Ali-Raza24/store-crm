<?php

namespace App\Http\Requests\Admin;

use App\Models\Business;
use App\Models\Store;
use App\Rules\OnlyNumbers;
use App\Rules\UrlRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BusinessRequest extends FormRequest
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
        $ownerEmailUnique = 'unique:businesses,owner_email';
        $adminEmailUnique = 'unique:businesses,email';
        $storeEmailUnique = 'unique:stores,email';
        /*if (!empty(request('id'))){
            $ownerBusiness = Business::whereOwnerEmail(request('owner_email'))->where('id','!=',request('id'))->first();
            $adminBusiness = Business::whereEmail(request('email'))->where('id','!=',request('id'))->first();
            $storeBusiness = Store::whereEmail(request('store[0][email]'))->where('id','!=',request('id'))->first();
            if ($ownerBusiness){
                $ownerEmailUnique = Rule::unique((new Business())->getTable(), 'owner_email');
            }
            if ($adminBusiness){
                $adminEmailUnique = Rule::unique((new Business())->getTable(), 'email');
            }
            if ($storeBusiness){
                $storeEmailUnique = Rule::unique((new Store())->getTable(),'email');
            }
        }*/
        $rules = [
            'owner_name' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
            'owner_email' => [
                'required',
                'max:50',
                'email:rfc,dns',
                $ownerEmailUnique
            ],
            'owner_phone' => ['required','digits_between:5,10', new OnlyNumbers()],
            'owner_mobile' => ['required','digits_between:10,15', new OnlyNumbers()],
            'business_type_id' => 'required',
            'name' => 'required',
            'email' => ['required','email:rfc,dns', $adminEmailUnique],
            'phone' => ['required','digits_between:5,10', new OnlyNumbers()],
            'mobile' => 'required|numeric|digits_between:10,15',
//            'brand_color' => 'required',
//            'minimum_order_amount' => 'nullable|numeric',
            'url' => ['required', new UrlRule(), 'max:50'],
            'plan_id' => 'required',
//            'address_1' => 'required',
//            'address_2' => 'required',
            'state_id' => 'required',
//            'country_id' => 'required',
            'stores.*.name' => 'required',
            'stores.*.email' => ['required', 'email:rfc,dns', $storeEmailUnique],
            'stores.*.phone' => ['required','digits_between:5,10', new OnlyNumbers()],
            'stores.*.mobile' => ['required','digits_between:10,15', new OnlyNumbers()],
//            'stores.*.address_1' => 'required',
//            'stores.*.address_2' => 'required',
//            'stores.*.opening_time' => 'required',
//            'stores.*.closing_time' => 'required',
            'stores.*.delivery_limit_km' => ['nullable', new OnlyNumbers('delivery limit')],
//            'stores.*.is_own_delivery' => 'required',
//            'stores.*.delivery_company_id' => 'required',
//            'stores.*.latitude' => 'required',
//            'stores.*.longitude' => 'required',
//            'stores.*.industry_id' => 'required',
            'stores.*.state_id' => 'required',
//            'stores.*.country_id' => 'required',
        ];

        $extraRules = [];
        if (empty(request('id'))) {
            $extraRules['password'] = 'required|min:8|max:50';
        }
        return array_merge($rules, $extraRules);
    }

    public function messages()
    {
        $parent = parent::messages();
        $messages = [
            'state_id.required' => 'The city field is required',
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
