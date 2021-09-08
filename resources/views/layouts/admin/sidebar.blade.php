<h2 class="d-none">SEO Purpose Heading</h2>
<aside class="sidebar">
    <a href="@if(!Route::is('admin-dashboard')){{route('admin-dashboard')}}@else#@endif" class="sidebar-brand mobile-hide"> <img alt="" src="{{asset('images/yabee_logo_1.png')}}" /> </a>
    <ul class="sidebar-list">
        <li>
            <a href="@if(!Route::is('admin-dashboard')){{route('admin-dashboard')}}@else#@endif" class="{{request()->is('admin/dashboard') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('admin_assets/images/home.png')}}"/>
                    <img alt="" class="img-hover" src="{{asset('admin_assets/images/home-green.png')}}"/>
                </span>
                <span class="list-text">Home</span>
            </a>
        </li>
        <li>
            <a href="@if(!Route::is('admin-business-list')){{route('admin-business-list')}}@else#@endif" class="{{request()->is('admin/business*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('admin_assets/images/business-white.png')}}"/>
                    <img alt="" class="img-hover" src="{{asset('admin_assets/images/business-green.png')}}"/>
                </span>
                <span class="list-text">Business</span>
            </a>
        </li>
        <li>
            <a href="@if(!Route::is('admin-orders-list')){{route('admin-orders-list')}}@else#@endif" class="{{request()->is('admin/orders*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('admin_assets/images/orders.png')}}"/>
                    <img alt="" class="img-hover" src="{{asset('admin_assets/images/orders-green.png')}}"/>
                </span>
                <span class="list-text">Orders</span>
            </a>
        </li>
        <li>
            <a href="@if(!Route::is('admin-customers-list')){{route('admin-customers-list')}}@else#@endif" class="{{request()->is('admin/customers*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('admin_assets/images/customers.png')}}"/>
                    <img alt="" class="img-hover" src="{{asset('admin_assets/images/customers-green.png')}}"/>
                </span>
                <span class="list-text">Customers</span>
            </a>
        </li>
        <li>
            <a href="@if(!Route::is('admin-areas-list')){{route('admin-areas-list')}}@else#@endif" class="{{request()->routeIs('admin-areas-list') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('admin_assets/images/area-white.png')}}"/>
                    <img alt="" class="img-hover" src="{{asset('admin_assets/images/area-green.png')}}"/>
                </span>
                <span class="list-text">Areas</span>
            </a>
        </li>
        <li class="d-none">
            <a href="@if(!Route::is('admin-reports')){{route('admin-reports')}}@else#@endif" class="{{request()->routeIs('admin-reports') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('admin_assets/images/analytics.png')}}"/>
                    <img alt="" class="img-hover" src="{{asset('admin_assets/images/analytics-green.png')}}"/>
                </span>
                <span class="list-text">Reports</span>
            </a>
        </li>
        <li>
            <a href="@if(!Route::is('admin-company-setting')){{route('admin-company-setting')}}@else#@endif" class="{{request()->is('admin/settings*') ? 'active' : ''}}">
                <span class="list-icon">
                    <img alt="" class="img-static" src="{{asset('admin_assets/images/settings-dark.png')}}"/>
                    <img alt="" class="img-hover" src="{{asset('admin_assets/images/settings-dark-active.png')}}"/>
                </span>
                <span class="list-text">Settings</span>
            </a>
        </li>
    </ul>
</aside>
<div class="close-sidebar"></div>
