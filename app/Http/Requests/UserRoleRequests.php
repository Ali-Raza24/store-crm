<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Role;

class UserRoleRequests extends FormRequest
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

        $nameUnique = '';
        if (!empty(request('id'))){
            if(Auth::user()->business_id == 0){
                $role = Role::whereName(request('role_name'))->where('business_id', 0)->where('id','!=',request('id'))->first();
                if ($role){
                    $nameUnique = Rule::unique((new Role())->getTable(), 'name');
                }
            }
            else {
                // Business Role Name Validaton
                $role = Role::whereName(request('role_name'))->where('business_id', Auth::user()->business_id)->where('id','!=',request('id'))->first();
                if ($role){
                    $nameUnique = Rule::unique((new Role())->getTable(), 'name');
                }
            }
        }
        else{
            // Business Role Name Validaton
            $role = Role::whereName(request('role_name'))->where('business_id', Auth::user()->business_id)->first();
            if ($role){
                $nameUnique = Rule::unique((new Role())->getTable(), 'name');
            }
        }



        $rules = [
            'role_name' => ['required', $nameUnique],
            'permission' => 'required|array'
        ];

        return $rules;
    }
    public function messages()
    {
        $parent = parent::messages();
        return array_merge($parent, [
            'role_name' => 'Role name is required',
            'permission' => 'Please select at least one Permission',
        ]);
    }
}
