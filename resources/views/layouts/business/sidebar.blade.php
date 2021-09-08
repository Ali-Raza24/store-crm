<h2 class="d-none">SEO Purpose Heading</h2>
<aside class="sidebar">
    <a href="@if(!Route::is('business-dashboard')){{route('business-dashboard')}}@else#@endif" class="sidebar-brand mobile-hide">
        <img alt="" src="{{asset('images/yabee_logo_1.png')}}">
    </a>
    <ul class="sidebar-list">
        @if(plan_has_permission(['business-dashboard']))
            <li>
                <a href="@if(!Route::is('business-dashboard')){{route('business-dashboard')}}@else#@endif"
                   class="{{request()->routeIs('business-dashboard') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('business_assets/images/home.png')}}">
                    <img alt="" class="img-hover" src="{{asset('business_assets/images/home-green.png')}}">
                </span>
                    <span class="list-text">Home</span>
                </a>
            </li>
        @endif
        @if(plan_permission('order'))
            <li>
                <a href="@if(!Route::is('orders-list')){{route('orders-list')}}@else#@endif" class="{{request()->is('*orders*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('business_assets/images/orders.png')}}">
                    <img alt="" class="img-hover" src="{{asset('business_assets/images/orders-green.png')}}">
                </span>
                    <span class="list-text">Orders</span>
                </a>
            </li>
        @endif
        @if(plan_has_permission(['report-basic', 'report-advanced']))
            <li class="d-none">
                <a href="@if(!Route::is('analytics')){{route('analytics')}}@else#@endif" class="{{request()->is('*analytics*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('business_assets/images/analytics.png')}}">
                    <img alt="" class="img-hover" src="{{asset('business_assets/images/analytics-green.png')}}">
                </span>
                    <span class="list-text">Analytics</span>
                </a>
            </li>
        @endif
            @if(\App\Helpers\ArrayHelper::hasAnyValues(Arr::pluck($selectedPlanOptions, 'option'), [\App\Constants\AppConstants::PLAN_OPTION_CUSTOMER_LISTING]))
        @if(plan_permission('customer') && \App\Helpers\ArrayHelper::hasAnyValues(Arr::pluck($selectedPlanOptions, 'values'), ['yes-customer']))
            <li>
                <a href="@if(!Route::is('customers-list')){{route('customers-list')}}@else#@endif" class="{{request()->is('*customers*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('business_assets/images/customers.png')}}">
                    <img alt="" class="img-hover" src="{{asset('business_assets/images/customers-green.png')}}">
                </span>
                    <span class="list-text">Customers</span>
                </a>
            </li>
        @endif
            @endif
        @if(plan_permission('product'))
            <li>
                <a href="@if(!Route::is('products-list')){{route('products-list')}}@else#@endif" class="{{request()->is('*products*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('business_assets/images/products.png')}}">
                    <img alt="" class="img-hover" src="{{asset('business_assets/images/products-green.png')}}">
                </span>
                    <span class="list-text">Products</span>
                </a>
            </li>
        @endif
            @php
                $couponInclude = false;
                $plansValues=[];
                $couponOption = [];
                if (\App\Helpers\ArrayHelper::hasAnyValues(Arr::pluck($selectedPlanOptions, 'option'), [\App\Constants\AppConstants::PLAN_OPTION_INCLUDED_PLAN])){
                    $couponOption = \App\Helpers\ArrayHelper::get(Arr::pluck($selectedPlanOptions, 'values', 'option'), 'includes_plan');
                    foreach (explode(',', $couponOption) as $item){
                        $plansValues = array_merge($plansValues, \App\Helpers\ArrayHelper::toArray(\App\Models\PlanOptions::wherePlanId($item)->pluck('values','option')));
                        if (Arr::get($plansValues, 'coupon_code') == 'yes-coupon'){
                            $couponInclude = true;
                        }
                    }
                }
            @endphp
            @if(\App\Helpers\ArrayHelper::hasAnyValues(Arr::pluck($selectedPlanOptions, 'option'), [\App\Constants\AppConstants::PLAN_OPTION_COUPON_CODE]) || $couponInclude)
        @if(plan_permission('discount') && (\App\Helpers\ArrayHelper::hasAnyValues(Arr::pluck($selectedPlanOptions, 'values'), ['yes-coupon']) || $couponInclude))
            <li>
                <a href="@if(!Route::is('discount-list')){{route('discount-list')}}@else#@endif" class="{{request()->is('*discounts*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('business_assets/images/discount.png')}}">
                    <img alt="" class="img-hover" src="{{asset('business_assets/images/discount-green.png')}}">
                </span>
                    <span class="list-text">Discount</span>
                </a>
            </li>
        @endif
            @endif
        @if(plan_has_permission(['store-info', 'eid-and-trade-license', 'store-create', 'account-info', 'notification-setting', 'bank-details', 'checkout-setting', 'payment-setting','shipping-general', 'shipping-areas']) || plan_permission('zone') || plan_permission('page') || plan_permission('user') || plan_permission('role'))
            <li>
                <a href="
                        @if(plan_has_permission(['store-info', 'eid-and-trade-license', 'store-create']))
                            @if(!Route::is('general-setting-store')){{route('general-setting-store')}}@else#@endif
                        @elseif(plan_has_permission(['account-info']))
                            @if(!Route::is('general-setting-account')){{route('general-setting-account')}}@else#@endif
                        @elseif(plan_has_permission(['notification-setting']) && Route::has('general-setting-notification'))
                            @if(!Route::is('general-setting-notification')){{route('general-setting-notification')}}@else#@endif
                        @elseif(plan_has_permission(['checkout-setting']))
                            @if(!Route::is('general-setting-checkout')){{route('general-setting-checkout')}}@else#@endif
                        @elseif(plan_has_permission(['payment-setting']))
                            @if(!Route::is('general-setting-payment')){{route('general-setting-payment')}}@else#@endif
                        @elseif(plan_permission('page'))
                            @if(!Route::is('business-page-setting')){{route('business-page-setting')}}@else#@endif
                        @elseif(plan_has_permission(['shipping-general', 'shipping-areas']))
                            @if(!Route::is('shipping-delivery-setting')){{route('shipping-delivery-setting')}}@else#@endif
                        @elseif(plan_permission('user'))
                            @if(!Route::is('user-list')){{route('user-list')}}@else#@endif
                        @elseif(plan_permission('role'))
                            @if(!Route::is('role-list')){{route('role-list')}}@else#@endif
                        @endif
                        "
                   class="{{request()->is('store-admin/settings*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('business_assets/images/settings-dark.png')}}" />
                    <img alt="" class="img-hover" src="{{asset('business_assets/images/settings-dark-active.png')}}" />
                </span>
                    <span class="list-text">Settings</span>
                </a>
            </li>
        @endif
    </ul>
</aside>
<div class="close-sidebar"></div>
