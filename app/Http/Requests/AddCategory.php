<?php
namespace App\Http\Requests;
use App\Rules\AlphaNumHyphenSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddCategory extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return  [
            'title' => [
                'required',
                new AlphaNumHyphenSpace(),
                Rule::unique('brands', 'title')->ignore($this->request->get('id'))
            ],
            'is_active' => [
                'required'
            ]
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Enter Category name!',
            'is_active.required' => 'Select status!',
            'title.unique' => 'Category name already exists',
            'title.regex' => 'Only alphabets are allowed'
        ];
    }
}
