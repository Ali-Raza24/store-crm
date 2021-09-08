<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AppConstants;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\PlanRequests;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

// use App\Role;

class PlanController extends ApiBaseController
{

    private $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
        parent::__construct('plan');
    }

    public function index()
    {
        $plans = Plan::whereNull('deleted_at')->whereNotIn('title',
            ['FreePlan'])->paginate(AppConstants::PAGINATE_SMALL);
        return view('admin.settings.plan', compact('plans'));
    }

    public function create(Request $request)
    {

        $groups = Permission::select(['group'])->where('group', '!=', 'dashboard')->whereIsBusiness(1)->groupBy('group')->get();
        $permissions = Permission::whereIsBusiness(1)->where('group', '!=', 'dashboard')->get();

        return view('admin.settings.plan-add', compact('groups', 'permissions'));
    }

    public function store(PlanRequests $request)
    {

        $this->planService->save($request);
        flash('Plan created successfully.')->success();
        return redirect()->route('admin-plans-setting');
    }

    public function planStatusUpdate(Request $request)
    {
        $plan_id = $request->get('plan_id');
        $status_id = $request->get('status_id');
        Plan::where('id', $plan_id)->update(['is_active' => $status_id]);

        flash('Plan status changed successfully')->success();
        return redirect()->back();
    }

    public function edit(Request $request, $plan_id)
    {
        $plan = Plan::with('planoption')->where('id', $plan_id)->first();

        $singlerole = \App\Models\Role::with([
            'permissions' => function ($q) {
                $q->select('id');
            }
        ])->where('id', $plan->role_id)->first();

        $existingPermissions = [];
        if ($singlerole) {
            foreach ($singlerole->permissions->toArray() as $item) {
                $existingPermissions[] = $item['id'];
            }

        }
        $groups = Permission::select(['group'])->where('group', '!=', 'dashboard')->whereIsBusiness(1)->groupBy('group')->get();
        $permissions = Permission::whereIsBusiness(1)->where('group', '!=', 'dashboard')->get();


        return view('admin.settings.plan-edit',
            compact('plan', 'singlerole', 'existingPermissions', 'groups', 'permissions'));
    }

    public function update(PlanRequests $request)
    {

        $this->planService->update($request);
        flash('Plan updated successfully.')->success();
        return redirect()->route('admin-plans-setting');
    }

    public function destroy(Request $request)
    {
        $plan = $this->planService->findById($request->plan_id);
        if ($plan->businessPlan->count() > 0) {
            flash('This plan associated with many businesses. You cannot delete this plan')->error();
            return redirect()->route('admin-plans-setting');
        }

        $this->planService->delete($request->plan_id);
        flash('Plan Deleted successfully.')->success();
        return redirect()->route('admin-plans-setting');
    }

    public function planOptionValue($key)
    {
        $planOption = CommonHelper::planOptions()[$key];

        if ($planOption['type'] == 'number') {
            return $this->sendSuccess('ok',
                ['html' => "<input type='number' data-option='$key' data-optionText='$key' data-item='option' name='option_val[" . $key . "]' class='form-control order-edit-control' />"]);
        } elseif ($planOption['type'] == 'radio') {
            $planOptionValues = CommonHelper::planOptionsValeus()[$key];
            $html = '';
            foreach ($planOptionValues as $item => $value) {
                $html .= "<input type='radio' name='option_val[" . $key . "]' data-option='$key' data-optionText='$value' data-item='option' value='$item'/> " . ucwords(str_replace('-',
                        ' ', $value)) . "</br>";
            }
            return $this->sendSuccess('ok', ['html' => $html]);
        } elseif ($planOption['type'] == 'checkbox') {
            $planOptionValues = CommonHelper::planOptionsValeus()[$key];
            $html = '';
            foreach ($planOptionValues as $item => $value) {
                $html .= "<input type='checkbox' name='option_val[" . $key . "]' data-option='$key' data-item='option' data-optionText='$value' value='$item'/> " . ucwords(str_replace('-',
                        ' ', $value)) . "</br>";
            }
            return $this->sendSuccess('ok', ['html' => $html]);
        }
    }

    public function planOptionText($key)
    {
        $planOption = CommonHelper::planOptionsText()[$key];
        return $this->sendSuccess('ok', ['text' => $planOption]);
    }
}
