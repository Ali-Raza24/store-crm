<?php

namespace App\Http\Requests;

use App\Models\Plan;
use App\Rules\AlphaNumHyphenSpace;
use App\Rules\AlphaSpaces;
use App\Rules\OnlyNumbers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequests extends FormRequest
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

    public function rules()
    {
        $rules = [
            'plan_title' => ['required', Rule::unique('plans','title')->whereNotNull('deleted_at'), new AlphaNumHyphenSpace()],
            'plan_monthly_price' => 'required|numeric',
            'plan_yearly_price' => 'required|numeric',
            'plan_desc' => 'nullable|min:5',
        ];

        return $rules;
    }

    public function messages()
    {
        $parent = parent::messages();
        return array_merge($parent, [
            'plan_title' => 'Title is required',
            'plan_title.unique' => 'Title already exists',
            'plan_monthly_price' => 'Monthly Price is required',
            'plan_yearly_price' => 'Yearly Price is required',
            'plan_desc' => 'Plan description is required',
            'plan_options.*' => 'Plan option is required',
            'plan_options_value' => 'Plan option value is required',
            'option.*.sort.min' => 'Option sort value must be greater than 0',
            'option.*.sort.distinct' => 'Option sort value already taken',
        ]);
    }
}
