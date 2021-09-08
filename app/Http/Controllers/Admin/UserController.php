<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// use App\Role;

class UserController extends Controller
{
    private $UserService;

    public function __construct(UserService $userService)
    {
        $this->UserService = $userService;
        parent::__construct('user');
    }

    public function index()
    {

    }

    public function store(UserRequests $request)
    {
        $showUsersListingtab = "showUsersListingtab";
        $this->UserService->save($request, false, 0, true);
        flash('User created successfully.');
        return redirect()->route('admin-user-list')->with($showUsersListingtab);

    }

    public function userStatusUpdate(Request $request)
    {
        $user_id = $request->get('user_id');
        $status_id = $request->get('status_id');
        User::where('id', $user_id)->update(['is_active' => $status_id]);
        $msg = 'active';
        if ($status_id == 1) {
            $msg = "active";
        } else {
            $msg = "InActive";
        }
        return response()->json($msg);
    }

    public function edit(Request $request, $user_id)
    {
        $userdetails = user::with('role')->with('image')->where('id', $user_id)->first();
        $users = User::with('roles')->where('is_business', 0)->get();
        $groups = Permission::select('group')->where('is_business', 0)->groupBy('group')->get();
        $permissions = Permission::where('is_business', 0)->get();
        $roles = Role::with('permissions')->where('is_business', 0)->get();

        $showUpdateUsertab = "showUpdateUsertab";
        return view("admin.settings.useredit", [
            'userdetails' => $userdetails,
            'permissions' => $permissions,
            'groups' => $groups,
            'roles' => $roles,
            'users' => $users
        ])->with('showUpdateUsertab', $showUpdateUsertab);

    }

    public function update(UserRequests $request, $user)
    {

        $this->UserService->update($request, $user);
        flash('User updated successfully.');
        $showUserListingtab = "showUserListingtab";
        return redirect()->route('admin-user-list')->with($showUserListingtab);
    }

    public function destroy($id)
    {
        $showUsersListingtab = "showUsersListingtab";
        if ($id == 1) {
            flash('Admin user can not be deleted.')->success()->important();
            return redirect()->route('admin-user-list')->with($showUsersListingtab);
        }

        flash('User Deleted successfully.');
        return redirect()->route('admin-user-list')->with($showUsersListingtab);
    }

    public function show($id)
    {
        return true;
    }

    public function user(Request $request)
    {
        $permissionsList = [];
        $users = User::with('roles')->where('is_business', 0)->paginate(AppConstants::PAGINATE_SMALL);
        $groups = Permission::select('group')->where('is_business', 0)->groupBy('group')->get();
        // $permissions=Permission::where('is_business',0)->get();
        $roles = Role::with('permissions')->where('is_business', 0)->get();
        return view("admin.settings.user", ['groups' => $groups, 'roles' => $roles, 'users' => $users]);
    }

    public function add(Request $request)
    {
        // $userdetails = user::with('role')->where('id',$user_id)->first();
        $users = User::with('roles')->where('is_business', 0)->get();
        $groups = Permission::select('group')->where('is_business', 0)->groupBy('group')->get();
        $permissions = Permission::where('is_business', 0)->get();
        $roles = Role::with('permissions')->where('is_business', 0)->get();

        $showAddUsertab = "showAddUsertab";
        return view("admin.settings.useradd", [
            'permissions' => $permissions,
            'groups' => $groups,
            'roles' => $roles,
            'users' => $users
        ])->with('showAddUsertab', $showAddUsertab);

    }

    public function suspend(Request $request)
    {
        $staffId = explode(',', $request->staff_id);
        if (is_array($staffId)) {
            foreach ($staffId as $id) {
                $user = User::findOrFail($id);
                if ($user) {
                    $user->is_active = $request->status_id;
                    $user->save();
                }
            }
            flash('User suspended')->success()->important();
            return redirect()->back();
        }
        $user = User::findOrFail($request->staff_id);
        if ($user) {
            $user->is_active = $request->status_id;
            $user->save();
            flash('User suspended')->success()->important();
        } else {
            flash('Error in suspending')->success()->important();
        }
        return redirect()->back();
    }

}
