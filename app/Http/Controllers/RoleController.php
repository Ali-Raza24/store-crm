<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Helpers\ArrayHelper;
use App\Http\Requests\UserRoleRequests;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private $RoleService;

    public function __construct(RoleService $roleService)
    {
        $this->RoleService = $roleService;
        parent::__construct('role');
    }

    public function index()
    {

        $plan = optional(Auth::user()->business)->plan;
        $selectedPlanOptions = optional($plan)->planoption;
        $optionsList = [];
        $optionOptions = [];
        if ($selectedPlanOptions){
            $optionValues = array_column($selectedPlanOptions->toArray(),'values');
            foreach ($optionValues as $value){
                $seprated = explode(',', $value);
                if (count($seprated) > 1) {
                    foreach ($seprated as $item) {
                        $optionsList[] = $item;
                    }
                }else{
                    $optionsList[] = $value;
                }
            }
        }
        if (!ArrayHelper::hasAnyValues($optionsList, ['no-coupon'] )){
            $groups = Permission::select(['group'])->whereIsBusiness(1)->groupBy('group')->get();
            $permissions = Permission::whereIsBusiness(1)->get();
            $roles = Role::with('permissions')->where('business_id',
                Auth::user()->business_id)->paginate(AppConstants::PAGINATE_SMALL);
        }else {
            $roles = Role::with(['permissions' => function($q){
                $q->where('group','!=', 'discount');
            }])->where('business_id', Auth::user()->business_id)->paginate(AppConstants::PAGINATE_SMALL);

            $groups = Permission::select(['group'])->where('group','!=', 'discount')->whereIsBusiness(1)->groupBy('group')->get();
            $permissions = Permission::whereIsBusiness(1)->where('group','!=', 'discount')->get();
        }

        /*$groups = Permission::select('group')->where('is_business', '1')->groupBy('group')->get();
        $permissions = Permission::where('is_business', '1')->get();*/


        $showRoleListingtab = "showRoleListingtab";
        return view("business.settings.role",
            ['permissions' => $permissions, 'groups' => $groups, 'roles' => $roles])->with('showRoleListingtab',
            $showRoleListingtab);

    }

    public function add()
    {
        $plan = optional(Auth::user()->business)->plan;
        $selectedPlanOptions = optional($plan)->planoption;
        $optionsList = [];
        $optionOptions = [];
        if ($selectedPlanOptions){
            $optionValues = array_column($selectedPlanOptions->toArray(),'values');
            foreach ($optionValues as $value){
                $seprated = explode(',', $value);
                if (count($seprated) > 1) {
                    foreach ($seprated as $item) {
                        $optionsList[] = $item;
                    }
                }else{
                    $optionsList[] = $value;
                }
            }
        }
        if (!ArrayHelper::hasAnyValues($optionsList, ['no-coupon'] )){
            $groups = Permission::select(['group'])->whereIsBusiness(1)->groupBy('group')->get();
            $permissions = Permission::whereIsBusiness(1)->get();
        }else {
            $groups = Permission::select(['group'])->where('group','!=', 'discount')->whereIsBusiness(1)->groupBy('group')->get();
            $permissions = Permission::whereIsBusiness(1)->where('group','!=', 'discount')->get();
        }
        $roles = Role::with('permissions')->where('business_id',
            Auth::user()->business_id)->paginate(AppConstants::PAGINATE_SMALL);

        $showRoleAddtab = "showRoleAddtab";
        return view("business.settings.roleadd",
            ['permissions' => $permissions, 'groups' => $groups, 'roles' => $roles])->with('showRoleAddtab',
            $showRoleAddtab);

    }

    public function FindRoleById($id)
    {
        return $role = Role::find($id);
    }

    public function store(UserRoleRequests $request)
    {

        $this->RoleService->save($request);
        flash('Role created successfully.');
        // flash('Role updated successfully.');
        $showRoleListingtab = "showRoleListingtab";
        return redirect()->route('role-list')->with($showRoleListingtab);
    }

    public function update(UserRoleRequests $request, $role)
    {

        $this->RoleService->update($request, $role);
        flash('Role updated successfully.');
        $showRoleListingtab = "showRoleListingtab";
        return redirect()->route('role-list')->with($showRoleListingtab);
    }

    public function edit(Request $request, $id)
    {

        $plan = optional(Auth::user()->business)->plan;
        $selectedPlanOptions = optional($plan)->planoption;
        $optionsList = [];
        $optionOptions = [];
        if ($selectedPlanOptions){
            $optionValues = array_column($selectedPlanOptions->toArray(),'values');
            foreach ($optionValues as $value){
                $seprated = explode(',', $value);
                if (count($seprated) > 1) {
                    foreach ($seprated as $item) {
                        $optionsList[] = $item;
                    }
                }else{
                    $optionsList[] = $value;
                }
            }
        }
        if (!ArrayHelper::hasAnyValues($optionsList, ['no-coupon'] )){
            $groups = Permission::select(['group'])->whereIsBusiness(1)->groupBy('group')->get();
            $permissions = Permission::whereIsBusiness(1)->get();
        }else {
            $groups = Permission::select(['group'])->where('group','!=', 'discount')->whereIsBusiness(1)->groupBy('group')->get();
            $permissions = Permission::whereIsBusiness(1)->where('group','!=', 'discount')->get();
        }

        $singlerole = Role::with([
            'permissions' => function ($q) {
                $q->select('id');
            }
        ])->where('id', $id)->first();
        $existingPermissions = [];
        foreach ($singlerole->permissions->toArray() as $item) {
            $existingPermissions[] = $item['id'];
        }

        // $roles = Role::with('permissions')->get();
        $showUpdateRoletab = "showUpdateRoletab";
        return view("business.settings.roleedit", [
            'permissions' => $permissions,
            'groups' => $groups,
            'singlerole' => $singlerole,
            'existingPermissions' => $existingPermissions
        ])->with('showUpdateRoletab', $showUpdateRoletab);

    }

}
