<?php

namespace App\Http\Requests;

use App\Models\Discount;
use App\Rules\OnlyNumbers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountRequest extends FormRequest
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
            'discount_type' => 'required',
            'discount_percentage' => 'required_if:discount_type,1',
            'discount_amount' => 'required_if:discount_type,2',
            'max_usage' => [new OnlyNumbers(),'nullable'],
            'start_date' => 'required',
//            'end_date' => 'required',
            'start_time' => 'required',
//            'end_time' => 'required',
            'min_purchase_amount' => ['required_if:discount_type,2', 'numeric', 'nullable'],
            'min_purchase_quantity' => [new OnlyNumbers(),'nullable'],
            'products.0' => ['required_if:all_products,2'],
            'code' => [
                'required',
                'max:20',
                'min:1',
                Rule::unique((new Discount())->getTable(), 'code')->ignore(request('discount_id'))->where('business_id', \Auth::user()->business_id)
            ]
        ];


    }

    public function messages()
    {
        return [
            'code.required' => 'The discount code field is required',
            'code.unique' => 'This discount code already exists',
            'discount_type.required' => 'The discount type field is required',
            'discount_value.required' => 'The discount value field is required',
            'start_date.required' => 'The start date field is required',
            'end_date.required' => 'The end date field is required',
            'start_time.required' => 'The start time field is required',
            'end_time.required' => 'The end time field is required',
            'discount_percentage.required_if' => 'The discount percentage field is required',
            'discount_amount.required_if' => 'The discount amount field is required',
            'min_purchase_amount.required_if' => 'The minimum purchase amount is required on Flat discount',
            'products.0.required_if' => 'Please select at-least one product'
        ];
    }
}
