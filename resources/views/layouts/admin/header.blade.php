<header class="web-header" id="header">
    <div class="container-fluid">
        <div class="mobile-header">
            <span class="sidebar-toggle">
                <i></i>
                <i></i>
                <i></i>
            </span>
            <img alt="" src="{{asset('images/yabee_logo_mobile.png')}}" class="mobile-brand" />
            <div class="mobile-metas">
                <notification></notification>
            </div>
        </div>
        <div class="header-flexer">
            <div class="header-lefter mobile-hide">
                <h2 class="dark-one font-weight-700">@yield('heading', 'Dashboard')</h2>
                <h4 class="tagline dark-one font-weight-400">
                    Quick Overview
                </h4> </div>
            <form class="header-search">
                <search></search>
            </form>
            <div class="header-metas">
                <div class="d-flex align-items-center">
                    {{--<a href="{{route('admin-company-setting')}}" class="setting-page">
                        <img alt="" src="{{asset('admin_assets/images/setting.png')}}" />
                    </a>--}}
                    <notification></notification>
                    <div class="dropdown dropdown-profile">
                        <button class="dropdown-toggle" type="button" id="dropProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(\App\Helpers\CommonHelper::userLogo())
                                <img alt="" src="{{\App\Helpers\CommonHelper::userLogo()}}" style="border-radius: 100%" />
                            @else
                            <img alt="" src="{{asset('images/profile-small.png')}}" />
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropProfile">
                            <a class="dropdown-item" href="{{route('admin-company-setting')}}">
                                <img alt="" class="store-dropico" src="{{asset('admin_assets/images/setting.png')}}" />
                                General
                            </a>
                            <a class="dropdown-item d-none" href="javascript:void(0)">
                                <img alt="" class="store-dropico" src="{{asset('admin_assets/images/notification.png')}}" />
                                Notification
                            </a>
                            <a class="dropdown-item" href="{{route('business-page-setting')}}">
                                <img alt="" class="store-dropico" src="{{asset('admin_assets/images/payment.png')}}" />
                                Content Management
                            </a>
                            <a class="dropdown-item" href="{{route('admin-user-list')}}">
                                <img alt="" class="store-dropico" src="{{asset('admin_assets/images/userules.png')}}" />
                                User Roles & Permission
                            </a>
                            <a class="dropdown-item" href="{{route('admin-plans-setting')}}">
                                <img alt="" class="store-dropico" src="{{asset('admin_assets/images/store.png')}}" />
                                Plans
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" id='logout'>
                                <img alt="" class="store-dropico" src="{{asset('admin_assets/images/store.png')}}">
                                <form METHOD='POST' action='{{route('logout')}}' id='logoutForm' class='d-none'>@csrf</form>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
