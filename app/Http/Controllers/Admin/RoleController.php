<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Requests\UserRoleRequests;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Constants\AppConstants;

class RoleController extends Controller
{   private $RoleService;

    public function __construct(RoleService $roleService)
    {
        $this->RoleService = $roleService;
        parent::__construct('role');
    }

    public function index(){

        $permissionsList = [];
        // $users = User::with('roles')->where('is_business',0)->get();
        $groups =  Permission::select('group')->where('is_business',0)->groupBy('group')->get();
        $permissions=Permission::where('is_business',0)->get();
        $roles = Role::with('permissions')->whereDoesntHave('plan')->where('is_business',0)->paginate(AppConstants::PAGINATE_SMALL);

        $showRoleListingtab = "showRoleListingtab";
        return view("admin.settings.role",['permissions'=>$permissions,'groups'=>$groups,'roles'=>$roles])->with('showRoleListingtab',$showRoleListingtab);

    }

    public function add(){

        $groups =  Permission::select('group')->where('is_business',0)->groupBy('group')->get();
        $permissions=Permission::where('is_business',0)->get();
        $roles = Role::with('permissions')->where('is_business',0)->paginate(AppConstants::PAGINATE_SMALL);;

        $showRoleAddtab = "showRoleAddtab";
        return view("admin.settings.roleadd",['permissions'=>$permissions,'groups'=>$groups,'roles'=>$roles])->with('showRoleAddtab',$showRoleAddtab);

    }

    public function FindRoleById($id){
       return $role=Role::whereDoesntHave('plan')->find($id);
    }

    public function store(UserRoleRequests $request ){

        $this->RoleService->save($request);
        flash('Role created successfully.');
        $showRoleListingtab= "showRoleListingtab";
        return redirect()->route('admin-role-list')->with($showRoleListingtab);
    }

    public function update(UserRoleRequests $request,$role ){

        $this->RoleService->update($request,$role);
        flash('Role updated successfully.');
        $showRoleListingtab= "showRoleListingtab";
        return redirect()->route('admin-role-list')->with($showRoleListingtab);
    }

    public function edit(Request $request, $id){

        $singlerole = Role::with(['permissions' => function($q){
            $q->select('id');
        }])->where('id',$id)->first();
        $existingPermissions = [];
        foreach ($singlerole->permissions->toArray() as $item){
            $existingPermissions[] = $item['id'];
        }
        //dd($existingPermissions);
        $groups =  Permission::select('group')->groupBy('group')->get();
        $permissions=Permission::all();
        // $roles = Role::with('permissions')->get();
        $showUpdateRoletab= "showUpdateRoletab";
        return view("admin.settings.roleedit",['permissions'=>$permissions,'groups'=>$groups,'singlerole'=>$singlerole,'existingPermissions'=>$existingPermissions])->with('showUpdateRoletab',$showUpdateRoletab);

    }

}
