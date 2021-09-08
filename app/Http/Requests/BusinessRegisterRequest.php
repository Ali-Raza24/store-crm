<?php

namespace App\Http\Requests;

use App\Models\Business;
use Illuminate\Foundation\Http\FormRequest;

class BusinessRegisterRequest extends FormRequest
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
            'business_type_id' => 'required',
            'name' => 'required',
            'email' => 'required|email:dns,rfc|unique:'.(new Business())->getTable(),
            'phone' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'same:password',
            'plan_id' => 'required'
        ];
    }
}
