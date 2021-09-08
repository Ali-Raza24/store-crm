<?php

namespace App\Http\Requests;

use App\Models\StoreZone;
use App\Rules\AlphaNumHyphenSpace;
use Illuminate\Foundation\Http\FormRequest;

class StoreZoneRequest extends FormRequest
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
            'store_id' => 'required|exists:stores,id',
            'name' => ['required',new AlphaNumHyphenSpace()],
            'rate' => 'required|numeric|min:0',
            'delivery_company_id' => 'required',
            'days' => ['min:0', 'max:90', 'nullable'],
            /*'hours' => ['min:0', 'max:24', 'nullable'],
            'minutes' => ['min:0', 'max:90', 'nullable']*/
        ];
    }
}
