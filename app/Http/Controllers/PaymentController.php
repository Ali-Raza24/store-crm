<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Models\Business;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\PlanOptions;
use Auth;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $intent = Auth::user()->business->createSetupIntent();

        $planType = session()->get('plan_type');
        $planId = session()->get('plan_id');
        if ($planType == 1){
            $plan = Plan::whereStripeMonthlyId($planId)->first();
        }else{
            $plan = Plan::whereStripeYearlyId($planId)->first();
        }

        if ($planType == 1 && $plan->monthly_price == 0) {
            $business = Business::find(Auth::user()->business_id);
            if ($business) {
                $business->plan_id = $plan->id;
                $business->save();

                $user = Auth::user();
                $user->roles()->detach();
                $user->assignRole($plan->role);
                flash('Your subscription plan changed successfully')->success()->important();
                return redirect()->route('general-setting-store');
            }
        }

        if ($planType == 2 && $plan->monthly_price == 0) {
            $business = Business::find(Auth::user()->business_id);
            if ($business) {
                $business->plan_id = $plan->id;
                $business->save();

                $user = Auth::user();
                $user->roles()->detach();
                $user->assignRole($plan->role);
                flash('Your subscription plan changed successfully')->success()->important();
                return redirect()->route('general-setting-store');
            }
        }
        return view('business.subscribers.payment', compact('intent', 'plan', 'planType'));
    }

    public function charge(Request $request)
    {
        Stripe::setApiKey(config('cashier.secret'));
        /**
         * @var $plan Plan
         */
        if ($request->plan_type == 1){
            $plan = Plan::whereStripeMonthlyId($request->plan)->first();
        }else{
            $plan = Plan::whereStripeYearlyId($request->plan)->first();
        }

        $trialDays = PlanOptions::wherePlanId($plan->id)->whereOption(AppConstants::PLAN_OPTION_FREE_DAYS)->first();
        if (!$trialDays){
            $trialDays = 0;
        }
        Cashier::$calculatesTaxes = false;
        Cashier::useCustomerModel(Business::class);
        if (!Auth::user()->business->is_subscribed) {
            $paymentData = Auth::user()->business->newSubscription(
                'Plans', $request->plan
            );

            if (!empty($trialDays)) {
                $paymentData = $paymentData->trialDays(!empty($trialDays) ? $trialDays->values : 0);
            }

            $paymentData = $paymentData->create($request->paymentMethod);
        }else{
            $subscription = Auth::user()->business->subscription('Plans');
            $paymentData = $subscription->swap($request->plan);
        }

        $user = Auth::user();
        $user->roles()->detach();
        $user->assignRole($plan->role);

        $subscriptionData = $paymentData->jsonSerialize();

        if ($paymentData->id){
            $business = Business::find(Auth::user()->business_id);
            if ($business) {
                $business->plan_id = $plan->id;
                $business->save();

                $payment = new Payment();
                $payment->business_id = Auth::user()->business_id;
                $payment->payment_type_id = AppConstants::SUBSCRIPTION_PAYMENT;
                $payment->payment_method_id = AppConstants::PAYMENT_STRIPE;
                $payment->reference_number = $subscriptionData['stripe_id'];
                $payment->payment_data = json_encode(\Arr::except($subscriptionData,'owner'));
                $payment->amount = ($request->plan_type == 1) ? $plan->monthly_price : $plan->yearly_price;
                $payment->status = IStatus::ACTIVE;
                $payment->is_paid = IStatus::PAYMENT_PAID;
                $payment->save();
            }
            flash('Your subscription plan changed successfully')->success()->important();
            return redirect()->route('general-setting-store');
        }

        flash('Error in subscription upgrading')->error()->important();
        return redirect()->route('general-setting-store');
    }

    public function success(Request $request)
    {
        return 'payment-success';
    }

    public function cancel(Request $request)
    {
        return 'payment-cancel';
    }
}
