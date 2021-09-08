<nav class="tabs-head mobile-hide" id="allOrders">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @if(plan_has_permission(['store-info']))
            <a class="nav-item nav-link @if(request()->routeIs('general-setting-store')) active @endif"
               id="settStore-tab"
               href="@if(!Route::is('general-setting-store')){{route('general-setting-store')}}@else#@endif" role="tab" aria-controls="settStore" aria-selected="true">
                Store
            </a>
        @endif
        @if(plan_has_permission(['account-info']))
            <a class="nav-item nav-link @if(request()->routeIs('general-setting-account')) active @endif"
               id="settAccount-tab"
               href="@if(!Route::is('general-setting-account')){{route('general-setting-account')}}@else#@endif" role="tab" aria-controls="settAccount"
               aria-selected="false">
                Account
            </a>
        @endif
        @if(plan_has_permission(['account-info']))
            <a class="nav-item nav-link @if(request()->routeIs('general-setting-password')) active @endif"
               id="settAccount-tab"
               href="@if(!Route::is('general-setting-password')){{route('general-setting-password')}}@else#@endif" role="tab" aria-controls="settAccount"
               aria-selected="false">
                    Password
                </a>
            @endif
        @if(plan_has_permission(['order-setting']))
            <a class="nav-item nav-link @if(request()->routeIs('general-setting-order')) active @endif" id="settAccount-tab"
               href="@if(!Route::is('general-setting-order')){{route('general-setting-order')}}@else#@endif" role="tab" aria-controls="settAccount"
               aria-selected="false">
                Order
            </a>
        @endif
        @if(plan_has_permission(['notification-setting']))
            {{--<a class="nav-item nav-link @if(request()->routeIs('general-setting-notification')) active @endif" id="settNotificat-tab"
               href="{{route('general-setting-notification')}}" role="tab" aria-controls="settNotificat"
               aria-selected="false">
                Notifications
            </a>--}}
        @endif
        @if(plan_has_permission(['payment-setting']))
            <a class="nav-item nav-link @if(request()->routeIs('general-setting-payment')) active @endif"
               id="settPayment-tab"
               href="@if(!Route::is('general-setting-payment')){{route('general-setting-payment')}}@else#@endif" role="tab" aria-controls="settPayment"
               aria-selected="false">
                Payment
            </a>
        @endif
        @if(plan_has_permission(['checkout-setting']))
            <a class="nav-item nav-link @if(request()->routeIs('general-setting-checkout')) active @endif"
               id="settCheckout-tab"
               href="@if(!Route::is('general-setting-checkout')){{route('general-setting-checkout')}}@else#@endif" role="tab" aria-controls="settCheckout"
               aria-selected="false">
                Checkout
            </a>
        @endif
        <a class="nav-item nav-link @if(request()->routeIs('general-setting-fb-pixel')) active @endif"
           id="settCheckout-tab"
           href="@if(!Route::is('general-setting-fb-pixel')){{route('general-setting-fb-pixel')}}@else#@endif" role="tab" aria-controls="settCheckout"
           aria-selected="false">
            Facebook Pixel
        </a>
    </div>
</nav>
<div class="dropdown tabs-dropdown desktop-hide">
    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Store
    </button>
    <div class="dropdown-menu" aria-labelledby="dropTab">
        <a class="nav-item nav-link @if(request()->routeIs('general-setting-store')) active @endif"
           href="@if(!Route::is('general-setting-store')){{route('general-setting-store')}}@else#@endif"> Store </a>
        <a class="nav-item nav-link @if(request()->routeIs('general-setting-account')) active @endif"
           href="@if(!Route::is('general-setting-account')){{route('general-setting-account')}}@else#@endif"> Account </a>
        {{--        <a class="nav-item nav-link @if(request()->routeIs('general-setting-notification')) active @endif" href="{{route('general-setting-notification')}}"> Notifications </a>--}}
        <a class="nav-item nav-link @if(request()->routeIs('general-setting-payment')) active @endif"
           href="@if(!Route::is('general-setting-payment')){{route('general-setting-payment')}}@else#@endif"> Payment </a>
        <a class="nav-item nav-link @if(request()->routeIs('general-setting-checkout')) active @endif"
           href="@if(!Route::is('general-setting-checkout')){{route('general-setting-checkout')}}@else#@endif"> Checkout </a>
    </div>
</div>
