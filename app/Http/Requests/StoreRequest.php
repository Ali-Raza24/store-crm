<?php

namespace App\Http\Requests;

use App\Models\Business;
use App\Models\Industry;
use App\Models\State;
use App\Models\Store;
use App\Rules\UrlRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $id = null;
        if (!empty($this->request->id)) {
            $id = $this->request->id;
        }
        $rules = [];

        $stores = $this->request->get('stores');
        $stores = \Arr::first($stores);
        $store = Store::whereName($stores['name'])->whereBusinessId(\Auth::user()->business_id)->first();

        if ($store) {
            $rules = array_merge($rules,
                ['stores.0.name' => ['required', Rule::unique('stores', 'name')]]);
        }else{
            $rules = array_merge($rules,
                ['stores.0.name' => ['required']]);
        }
        $rules = array_merge($rules, [
            'stores.0.industry_id' => ['required', Rule::exists((new Industry())->getTable(), 'id')],
            'stores.0.state_id' => ['required', Rule::exists((new State())->getTable(), 'id')],
        ]);
        if (empty(\Auth::user()->business->url)) {
            $rules = array_merge($rules,
                ['url' => ['required', new UrlRule(), 'unique:' . (new Business())->getTable(), 'max:50']]);
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'stores.0.name.required' => 'The store name is required',
            'stores.0.name.unique' => 'The store name already been taken',
            'stores.0.industry_id.required' => 'The store industry field is required',
            'stores.0.industry_id.exists' => 'The store industry field is required',
            'stores.0.state_id.exists' => 'The city field is required',
            'stores.0.state_id.required' => 'The city field is required',
        ];
    }
}
