<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Models\Plan;
use App\Models\PlanOptions;
use App\Models\Role;
use App\Models\StripeProduct;
use Carbon\Carbon;
use Stripe\Product;
use Stripe\Stripe;
use function Symfony\Component\Translation\t;

class PlanService
{
    private $imageService;

    /**
     * @var $model Plan
     */
    private $model;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->model = new Plan();
        Stripe::setApiKey(config('cashier.secret'));
    }

    public function findById($id){
        return Plan::find($id);
    }

    public function findByBusinessId($id){
        return Plan::whereBusinessId($id)->first();
    }

    public function save($request)
    {
        $plan =new Plan();
        if(!empty($request->plan_title)){
            $plan->title = $request->plan_title;
        }

        if(!empty($request->plan_monthly_price)){
            $plan->monthly_price = $request->plan_monthly_price;
        } else if ($request->plan_monthly_price == 0){
            $plan->monthly_price = $request->plan_monthly_price;
        }

        if(!empty($request->plan_yearly_price)){
            $plan->yearly_price = $request->plan_yearly_price;
        } else if ($request->plan_yearly_price == 0){
            $plan->yearly_price = $request->plan_yearly_price;
        }

        if(!empty($request->plan_desc)){
            $plan->description = $request->plan_desc;
        }

        $plan->save();

        $form_data = $request->all();

        if (is_array($request->option) && !empty(\Arr::first($request->option))) {

            foreach ($request->option as $option) {
                $planOption = new PlanOptions();
                $planOption->plan_id = $plan->id;
                $planOption->option = $option['option'];
                $planOption->values = $option['value'];
                $planOption->option_text = $option['text'];
                $planOption->save();
            }
        }

        $role = new \Spatie\Permission\Models\Role();
        $role->name = $request->plan_title;
        $role->guard_name = 'web';
        $role->is_business = 0;
        $role->business_id = 0;
        $role->save();

        $plan->role_id = $role->id;
        $plan->save();
        if (is_array($request->permission) && count($request->permission) > 0){

            $role->syncPermissions($request->permission);
        }

        $this->stripe($plan);

    }

    /**
     * @param $plan Plan
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function stripe($plan)
    {
        $product = [];
        try{
            $product = Product::retrieve('plan');
        }catch (\Stripe\Exception\InvalidRequestException $exception){
            $product = null;
        }

        if (!$product) {
            $product = Product::create(['name' => 'Plans', 'id' => 'plan']);
            if (!StripeProduct::whereStripeId($product->id)->first()) {
                $stripeProduct = new StripeProduct();
                $stripeProduct->name = $product->name;
                $stripeProduct->stripe_id = $product->id;
                $stripeProduct->save();
            }
        }

        $stripePlanMonthly = null;
        try{
            $stripePlanMonthly = \Stripe\Plan::retrieve(\Str::slug($plan->title).'-monthly');
        }catch (\Stripe\Exception\InvalidRequestException $exception){
            $stripePlanMonthly = null;
        }

        if (!$stripePlanMonthly) {
            try {
                $stripePlanMonthly = \Stripe\Plan::update($plan->stripe_id, [
                    'currency' => 'AED',
                    'product' => $product->id,
                    'amount' => $plan->monthly_price*100,
                    'interval' => 'month',
                    'interval_count' => 1,
                    'trial_period_days' => optional($plan->planoption()->where(['option' => AppConstants::PLAN_OPTION_FREE_DAYS])->first())->values,
                    'id' => \Str::slug($plan->title).'-monthly'
                ]);
            }catch (\UnexpectedValueException $exception){
                try {
                    $stripePlanMonthly = \Stripe\Plan::create([
                        'currency' => 'AED',
                        'product' => $product->id,
                        'amount' => $plan->monthly_price*100,
                        'interval' => 'month',
                        'interval_count' => 1,
                        'trial_period_days' => optional($plan->planoption()->where(['option' => AppConstants::PLAN_OPTION_FREE_DAYS])->first())->values,
                        'id' => \Str::slug($plan->title).'-monthly'
                    ]);
                }catch (\Stripe\Exception\InvalidRequestException $exception){
                    $stripePlanMonthly = null;
                }
            }
        }
        $plan = Plan::find($plan->id);
        $plan->stripe_monthly_id = optional($stripePlanMonthly)->id;
        $plan->save();

        $stripePlanYearly = null;
        try{
            $stripePlanYearly = \Stripe\Plan::retrieve(\Str::slug($plan->title).'-yearly');
        }catch (\Stripe\Exception\InvalidRequestException $exception){
            $stripePlanYearly = null;
        }

        if (!$stripePlanYearly) {
            try {
                $stripePlanYearly = \Stripe\Plan::update($plan->stripe_id, [
                    'currency' => 'AED',
                    'product' => $product->id,
                    'amount' => $plan->yearly_price*100,
                    'interval' => 'year',
                    'interval_count' => 1,
                    'trial_period_days' => optional($plan->planoption()->where(['option' => AppConstants::PLAN_OPTION_FREE_DAYS])->first())->values,
                    'id' => \Str::slug($plan->title).'-yearly'
                ]);
            }catch (\UnexpectedValueException $exception){
                try {
                    $stripePlanYearly = \Stripe\Plan::create([
                        'currency' => 'AED',
                        'product' => $product->id,
                        'amount' => $plan->yearly_price*100,
                        'interval' => 'year',
                        'interval_count' => 1,
                        'trial_period_days' => optional($plan->planoption()->where(['option' => AppConstants::PLAN_OPTION_FREE_DAYS])->first())->values,
                        'id' => \Str::slug($plan->title).'-yearly'
                    ]);
                }catch (\Stripe\Exception\InvalidRequestException $exception){
                    $stripePlanYearly = null;
                }
            }
        }
        $plan = Plan::find($plan->id);
        $plan->stripe_yearly_id = optional($stripePlanYearly)->id;
        $plan->save();
    }

    public function update($request)
    {

        $plan= Plan::where('id',$request->plan_id)->first();

        if(!empty($request->plan_title)){
            $plan->title = $request->plan_title;
        }

        if(!empty($request->plan_monthly_price)){
            $plan->monthly_price = $request->plan_monthly_price;
        } else if ($request->plan_monthly_price == 0){
            $plan->monthly_price = $request->plan_monthly_price;
        }

        if(!empty($request->plan_yearly_price)){
            $plan->yearly_price = $request->plan_yearly_price;
        } else if ($request->plan_yearly_price == 0){
            $plan->yearly_price = $request->plan_yearly_price;
        }

        if(!empty($request->plan_desc)){
            $plan->description = $request->plan_desc;
        }
        $plan->save();
        $form_data = $request->all();

        PlanOptions::where('plan_id',$request->plan_id)->delete();

        if (is_array($request->option) && !empty(\Arr::first($request->option))) {

            foreach ($request->option as $option) {
                $planOption = new PlanOptions();
                $planOption->plan_id = $plan->id;
                $planOption->option = $option['option'];
                $planOption->values = $option['value'];
                $planOption->option_text = $option['text'];
                $planOption->save();
            }
        }

        if (is_array($request->permission) && count($request->permission) > 0){
            $role = Role::find($request->role_id);
            if ($role) {
                $role->name = $request->plan_title;
                $role->save();

                $role->syncPermissions($request->permission);
            } else {
                $role = new Role();
                $role->name = $request->plan_title;
                $role->guard_name = 'web';
                $role->is_business = 0;
                $role->business_id = 0;
                $role->save();

                $plan->role_id = $role->id;
                $plan->save();

                $role->syncPermissions($request->permission);
            }
        }

        $this->stripe($plan);

    }

    public function delete($id){
        $plan = Plan::find($id);
        if(!empty($plan)) {
            $plan->deleted_at = Carbon::now();
            $plan->save();
        }
        $planoption =  PlanOptions::where('plan_id',$id)->get();
        if(!empty($planoption)){
            foreach ($planoption as $opt) {
                $optionPlan = PlanOptions::find($opt->id);
                $optionPlan->deleted_at = Carbon::now();
                $optionPlan->save();
            }
        }


    }
}
