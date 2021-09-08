<header class="web-header" id="header">
    <div class="container-fluid">
        <div class="mobile-header desktop-hide d-sm-flex d-lg-none">
            <div class="">
                <img alt="" src="{{asset('images/yabee_logo_mobile.png')}}" class="mobile-brand">
            </div>
            <div class="header-metas">
                <div class="d-flex align-items-center">
                    <div class="dropdown dropdown-profile">
                        <button class="dropdown-toggle" type="button" id="dropProfile" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            @if(\App\Helpers\CommonHelper::userLogo('profile'))
                                <img alt="" class="profileImage" src="{{\App\Helpers\CommonHelper::userLogo('profile')}}" style="border-radius: 100%; "/>
                            @else
                                <img alt="" src="{{asset('images/profile-small.png')}}" />
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropProfile">
                            <a class="dropdown-item" href="{{config('urls.store_url')}}/{{optional($business)->url}}" target="_blank">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/notification.png')}}">
                                View Shop
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" id='logout'>
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/store.png')}}">
                                <form METHOD='POST' action='{{route('logout')}}' id='logoutForm' class='d-none'>@csrf</form>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-flexer mobile-hide">
            <div class="header-lefter">
                <h2 class="dark-one font-weight-700">@yield('header_heading','Select Store')</h2>
                <h4 class="tagline dark-one font-weight-400">@yield('header_subheading', $business->name)</h4>
            </div>
            <div class="header-metas">
                <div class="d-flex align-items-center">
                    <div class="dropdown dropdown-profile">
                        <button class="dropdown-toggle" type="button" id="dropProfile" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            @if(\App\Helpers\CommonHelper::userLogo('profile'))
                                <img alt="" class="profileImage" src="{{\App\Helpers\CommonHelper::userLogo('profile')}}" style="border-radius: 100%; "/>
                        @else
                            <img alt="" src="{{asset('images/profile-small.png')}}" />
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropProfile">
                            <a class="dropdown-item" href="{{config('urls.store_url')}}/{{optional($business)->url}}" target="_blank">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/notification.png')}}">
                                View Shop
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" id='logout'>
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/store.png')}}">
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
