<nav class="tabs-head mobile-hide" id="allOrders">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link @if(request()->routeIs('admin-company-setting')) active @endif" href="{{route('admin-company-setting')}}">
            Company Information
        </a>
        <a class="nav-item nav-link @if(request()->routeIs('admin-testimonials-tab')) active @endif" href="{{ route('admin-testimonials-tab') }}">
            Testimonials
        </a>
        {{--<a class="nav-item nav-link" href="">
            Emirates
        </a>--}}
        <a class="nav-item nav-link @if(request()->routeIs('admin-businesses-tab')) active @endif" href="{{ route('admin-businesses-tab') }}">
            Featured Business
        </a>
        <a class="nav-item nav-link @if(request()->routeIs('aramex-integrate')) active @endif" href="{{ route('aramex-integrate') }}">
            Aramex Integration
        </a>
        {{--<a class="nav-item nav-link @if(request()->routeIs('admin-payment-setting')) active @endif" href="{{ route('admin-payment-setting') }}">
            Payment Setting
        </a>--}}
    </div>
</nav>
<div class="dropdown tabs-dropdown desktop-hide">
    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Company Information
    </button>
    <div class="dropdown-menu" aria-labelledby="dropTab">
        <a class="nav-item nav-link @if(request()->routeIs('admin-company-setting')) active @endif" href="{{route('admin-company-setting')}}">
            Company Information
        </a>
        <a class="nav-item nav-link @if(request()->routeIs('admin-testimonials-tab')) active @endif" href="{{ route('admin-testimonials-tab') }}">
            Testimonials
        </a>
        {{--<a class="nav-item nav-link" href="javascript:void(0)">
            Emirates
        </a>--}}
        <a class="nav-item nav-link @if(request()->routeIs('admin-businesses-tab')) active @endif" href="{{ route('admin-businesses-tab') }}">
            Featured Business
        </a>
        {{--<a class="nav-item nav-link @if(request()->routeIs('admin-payment-setting')) active @endif" href="{{ route('admin-payment-setting') }}">
            Payment Setting
        </a>--}}
    </div>
</div>

