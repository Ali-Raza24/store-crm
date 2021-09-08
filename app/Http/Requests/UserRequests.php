<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequests extends FormRequest
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
        $emailUnique = '';
        if (!empty(request('id'))){
            $User = User::whereEmail(request('email'))->where('id','!=',request('id'))->first();
            if ($User){
                $emailUnique = Rule::unique((new User())->getTable());
            }
        }
        else{
            $emailUnique = 'unique:users';
        }

        $rules = [
            'name' => 'required|min:8',
            'email' => [
                'required',
                'max:50',
                $emailUnique
            ],
            'userRole' => 'required'
        ];


        if($this->getMethod() == 'POST'){
            $rules['password'] = 'required|confirmed|min:8|max:50';
        }

        return $rules;
    }
    public function messages()
    {
        $parent = parent::messages();
        return array_merge($parent, [
            'name' => 'Name is required',
            'email' => 'Email is required',
            'password.required' => 'Password is required',
            'userRole' => 'Please select at least one Role',
        ]);
    }
}
