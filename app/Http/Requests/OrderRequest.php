<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\State;
use App\Rules\AlphaSpaces;
use App\Rules\OnlyNumbers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
        $rules =  [
            'cart.*.product_id' => ['required', Rule::exists((new Product())->getTable(),'id')],
            'cart.*.qty' => ['required',new OnlyNumbers()],
            'cart.*.price' => ['required', 'numeric'],
            'cart.*.discount' => ['required', 'numeric'],
            'shippingInfo.same_billing_address' => ['required', 'boolean'],
            'shippingInfo.shipping_address.name' => ['required', new AlphaSpaces()],
            'shippingInfo.shipping_address.state' => ['required'],
//            'shippingInfo.shipping_address.zip' => ['required'],
//            'shippingInfo.shipping_address.area' => ['required'],
            'total' => ['required'],
            'payment.type' => ['required'],
            'payment.payment_method_id' => ['required']
        ];

        $checkoutSetting = setting('checkout');
        $checkoutSetting = json_decode($checkoutSetting);

        if (!empty($checkoutSetting->with_email)){
            $rules = array_merge($rules, ['shippingInfo.shipping_address.email' => ['required', 'email:dns,rfc']]);
        }

        if (!empty($checkoutSetting->with_mobile)){
            $rules = array_merge($rules, ['shippingInfo.shipping_address.phone' => ['required', new OnlyNumbers()]]);
        }

        return $rules;
    }
}
