<?php

namespace App\Http\Controllers;

use App\Constants\IStatus;
use App\Models\Plan;
use App\Models\PlanOptions;
use App\Models\Store;
use App\Models\User;
// use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequests;
use App\Constants\AppConstants;
use Illuminate\Support\Facades\Auth;

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
        $this->UserService->save($request, null, 0, true);
        flash('User created successfully.');
        return redirect()->route('user-list')->with($showUsersListingtab);

    }

    public function userStatusUpdate(Request $request)
    {
        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_STAFF)->first();

        $userCount = User::whereBusinessId(Auth::user()->business_id)->whereNull('deleted_at')->count('id');

        $status = $request->status_id;
        if (!empty($planOption->values) && ($planOption->values > $userCount || $status == IStatus::DISABLE)){
            $id = $request->user_id;
            $user = User::find($id);

            if ($user) {
                $user->is_active = $status;
                $user->save();
            }
            if ($status == IStatus::ACTIVE) {
                flash('User status activated successfully')->success()->important();
            } else {
                flash('User status inactivated successfully')->success()->important();
            }
        }else{
            flash('Cannot active this staff. You have reached to your maximum staff limit. Please upgrade your subscription to continue! ')->error()->important();
        }
        /*if ($status_id == IStatus::ACTIVE) {
            flash('User activated successfully')->success();
        } else {
            flash('User inActivated successfully')->success();
        }*/
        return redirect()->back();
    }

    public function edit(Request $request, $user_id){
        $userdetails = user::with('role')->with('image')->where('id',$user_id)->first();
        $users = User::with('roles')->where('business_id', Auth::user()->business_id)->get();
        $groups =  Permission::select('group')->where('is_business', 1)->groupBy('group')->get();
        $permissions=Permission::where('is_business', 1)->get();
        $roles = Role::with('permissions')->where('business_id', Auth::user()->business_id)->get();

        $showUpdateUsertab= "showUpdateUsertab";
        return view("business.settings.useredit",['userdetails'=>$userdetails,'permissions'=>$permissions,'groups'=>$groups,'roles'=>$roles,'users'=>$users])->with('showUpdateUsertab',$showUpdateUsertab);

    }

    public function update(UserRequests $request, $user){

        // if($request->file('image'))
        //     \request()->request->add(['images' => [base64_encode(file_get_contents($request->file('image')))]]);
        // request()->request->add(['owner_email' => $request->email]);
        $this->UserService->update($request, $user);
        flash('User updated successfully.');
        $showUserListingtab= "showUserListingtab";
        return redirect()->route('user-list')->with($showUserListingtab);
    }

    public function destroy($id)
    {
        $this->UserService->delete($id);
        flash('User deleted successfully')->success();
        $showUsersListingtab = "showUsersListingtab";
        return redirect()->route('user-list')->with($showUsersListingtab);
    }

    public function show($id)
    {
        return true;
    }

    public function user(Request $request)
    {
        $users = User::with('roles')->where('business_id', Auth::user()->business_id)->whereNull('deleted_at')->paginate(AppConstants::PAGINATE_SMALL);

        $groups =  Permission::select('group')->where('is_business', 1)->groupBy('group')->get();
        $roles = Role::with('permissions')->where('business_id', Auth::user()->business_id)->get();

        return view("business.settings.user",['groups'=>$groups,'roles'=>$roles,'users'=>$users]);
    }

    public function add(Request $request){

        $plan = Plan::find(Auth::user()->business->plan_id);
        $planOption = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_STAFF)->first();
        $userCount = User::whereBusinessId(Auth::user()->business_id)->whereNull('deleted_at')->count('id');

        if ($planOption->values <=  $userCount){
            flash('You have reached to your maximum staff limit. Please upgrade your subscription to continue!')->error();
            return redirect()->route('user-list');
        }

        // $userdetails = user::with('role')->where('id',$user_id)->first();
        $users = User::with('roles')->where('business_id', Auth::user()->business_id)->get();
        $groups =  Permission::select('group')->where('is_business', 1)->groupBy('group')->get();
        $permissions=Permission::where('is_business', 1)->get();
        $roles = Role::with('permissions')->where('business_id', Auth::user()->business_id)->get();

        $showAddUsertab= "showAddUsertab";
        return view("business.settings.useradd",['permissions'=>$permissions,'groups'=>$groups,'roles'=>$roles,'users'=>$users])->with('showAddUsertab',$showAddUsertab);

    }

}
