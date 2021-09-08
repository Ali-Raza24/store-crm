<?php

namespace App\Services;
use App\Events\NewRoleCreated as NewRoleCreatedEvent;
use App\Events\RoleUpdated as RoleUpdatedEvent;
use App\Mail\NewRoleMail;
use App\Mail\UpdateRoleMail;
use App\Models\Business;
use App\Models\User;
use App\Notifications\NewRoleCreated as NewRoleCreatedNotify;
use App\Notifications\RoleUpdate as RoleUpdateNotify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleService
{
    private $model;
    public function __construct(Role $role)
    {
        $this->model = $role;
    }
    public function findById($id)
    {
        return $this->model->find($id);
    }
    public function save(Request $request)
    {
        if(Auth::user()->business_id)
            $reqeust_array = ['name' => $request->role_name, 'is_business' => 1, 'business_id' => Auth::user()->business_id];
        else
            $reqeust_array = ['name' => $request->role_name];
        $role = Role::create($reqeust_array);
        $role->save();
        $role->syncPermissions($request->permission);

        $object = new \stdClass();
        $object->user = Auth::user()->name;

        if (Auth::user()->business_id){
            Business::find(Auth::user()->business_id)->user->notify(new NewRoleCreatedNotify($object));
        } else {
            User::whereEmail(config('app.admin_user'))->first()->notify(new NewRoleCreatedNotify($object));
        }

        event(new NewRoleCreatedEvent());
        if (Auth::user()->business_id) {
            $newRoleMail = new NewRoleMail($role);
            \Mail::send($newRoleMail);
        }

        return $role;
    }
    public function update(Request $request, $id)
    {
        $role = $this->findById($id);
        $role->name = $request->role_name;
        $role->save();

        $role->syncPermissions($request->permission);

        $object = new \stdClass();
        $object->user = Auth::user()->name;

        if (Auth::user()->business_id){
            Business::find(Auth::user()->business_id)->user->notify(new RoleUpdateNotify($object));
        } else {
            User::whereEmail(config('app.admin_user'))->first()->notify(new RoleUpdateNotify($object));
        }

        event(new RoleUpdatedEvent());

        $updateRoleMale = new UpdateRoleMail($role);
        \Mail::send($updateRoleMale);

        return $role;
    }
    public function edit(Request $request)
    {
        $role = Role::find($request->role_name);

        return $role;
    }
}
