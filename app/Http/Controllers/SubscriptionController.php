<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Models\Business;
use App\Models\Plan;
use App\Models\PlanOptions;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SubscriptionController extends Controller
{
    public function upgrade(Request $request)
    {
        $intent = Auth::user()->business->createSetupIntent();
        $plans = Plan::whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->get();

        if ($request->getMethod() == Request::METHOD_POST){

            $errorCount = 0;

            if ($request->plan_type == 1){
                $plan = Plan::whereStripeMonthlyId($request->plan_id)->first();
            }else{
                $plan = Plan::whereStripeYearlyId($request->plan_id)->first();
            }

            $staff = false;
            $product = false;
            $store = false;

            $planOptionProducts = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_PRODUCTS)->first();
            if (!empty($planOptionProducts)) {
                $totalProducts = Product::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->count('id');
                if ($totalProducts > $planOptionProducts->values) {
                    $product = true;
                    $errorCount++;
                }
            }

            $planOptionStores = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_STORES)->first();
            if (!empty($planOptionStores)) {
                $totalStores = Store::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->count('id');

                if ($totalStores > $planOptionStores->values) {
                    $store = true;
                    $errorCount++;
                }
            }

            $planOptionStaff = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_STAFF)->first();
            if (!empty($planOptionStaff)) {
                $totalStaff = User::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->count('id');

                if ($totalStaff > $planOptionStaff->values) {
                    $staff = true;
                    $errorCount++;
                }
            }
            session()->put('plan_id', $request->plan_id);
            session()->put('plan_type', $request->plan_type);

            if ($errorCount > 0){
                if ($request->plan_type == 1){
                    $plan = Plan::whereStripeMonthlyId($request->plan_id)->first();
                }else{
                    $plan = Plan::whereStripeYearlyId($request->plan_id)->first();
                }

                return view('business.subscribers.downgrade', ['staff' => $staff, 'product' => $product, 'store' => $store, 'plan' => $plan, 'planType' => $request->plan_type]);
            }
            return redirect()->route('payment-form');
        }
        return view('business.subscribers.upgrade', compact('plans', 'intent'));
    }

    public function downgrade(Request $request)
    {
        $plans = Plan::whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->get();

        if ($request->getMethod() == Request::METHOD_POST) {
            $errorCount = 0;

            $planOptionProducts = PlanOptions::wherePlanId($request->plan_id)->whereOption(AppConstants::PLAN_OPTION_PRODUCTS)->first();
            if (!empty($planOptionProducts)) {
                $totalProducts = Product::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->count('id');
                if ($totalProducts > $planOptionProducts->values) {
                    flash('You have to disable minimum '.($totalProducts-$planOptionProducts->values).' products to downgrade subscription')->error()->important();
                    $errorCount++;
                }
            }

            $planOptionStores = PlanOptions::wherePlanId($request->plan_id)->whereOption(AppConstants::PLAN_OPTION_STORES)->first();
            if (!empty($planOptionStores)) {
                $totalStores = Store::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->count('id');

                if ($totalStores > $planOptionStores->values) {
                    flash('You have to disable minimum '.($totalStores-$planOptionStores->values).' stores to downgrade subscription')->error()->important();
                    $errorCount++;
                }
            }

            $planOptionStaff = PlanOptions::wherePlanId($request->plan_id)->whereOption(AppConstants::PLAN_OPTION_STAFF)->first();
            if (!empty($planOptionStaff)) {
                $totalStaff = User::whereBusinessId(\Auth::user()->business_id)->whereNull('deleted_at')->whereIsActive(IStatus::ACTIVE)->count('id');

                if ($totalStaff > $planOptionStaff->values) {
                    flash('You have to disable minimum '.($totalStaff-$planOptionStaff->values).' staff users to downgrade subscription')->error()->important();
                    $errorCount++;
                }
            }

            if ($errorCount > 0){
                return view('business.subscribers.downgrade');
            }
        }

        return view('business.subscribers.downgrade', compact('plans'));
    }
}
