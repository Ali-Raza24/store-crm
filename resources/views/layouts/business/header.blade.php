<header class="web-header" id="header">
    <div class="container-fluid">
        <div class="mobile-header">
                    <span class="sidebar-toggle">
                        <i></i> <i></i> <i></i>
                    </span>
            <img alt="" src="{{asset('images/yabee_logo_mobile.png')}}" class="mobile-brand">
            <div class="mobile-metas">
                <notification></notification>
            </div>
        </div>
        <div class="header-flexer">
            <div class="header-lefter mobile-hide">
                <h2 class="dark-one font-weight-700">@yield('header_heading','Dashboard')</h2>
                <h4 class="tagline dark-one font-weight-400">@yield('header_subheading', 'Quick Overview')</h4>
            </div>
            <form class="header-search">
            <search></search>
            </form>
            {{--<form class="header-search">

                <div class="form-group form-icon">
                    <input type="text" placeholder="Search your keyword..." class="form-control">
                    <span>
                        <img alt="" src="{{asset('business_assets/images/search.png')}}">
                    </span>
                </div>
            </form>--}}
            <div class="header-metas">
                <div class="dropdown dropdown-stores">
                    <button class="dropdown-toggle" type="button" id="dropStore" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?php $store = session()->get('store-data');?>
                            @if($store->is_active == \App\Constants\IStatus::DISABLE)
                                <span class="lg-show text-danger">{{session()->get('store-name')}} (inactive)</span>
                            @else
                                <span class="lg-show">{{session()->get('store-name')}}</span>
                            @endif
                            <span class="sm-show">{{session()->get('store-name')}}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropStore">
                        @foreach(\App\Helpers\CommonHelper::stores() as $store)
                        <a class="dropdown-item" href="{{route('change-store', ['name' => $store->slug])}}">
                            <span><img alt="" class="store-dropico"
                                       src="{{asset('business_assets/images/store.png')}}"> </span>
                            @if($store->is_active == \App\Constants\IStatus::DISABLE)
                                <span class="text-danger">{{$store->name}}</span>
                            @else
                                {{$store->name}}
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    {{--<a href="{{route('general-setting-store')}}" class="setting-page">
                        <img alt="" src="{{asset('business_assets/images/setting.png')}}">
                    </a>--}}

                    <notification></notification>
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
                            <a class="dropdown-item d-none" href="{{route('general-setting-store')}}">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/setting.png')}}">
                                General
                            </a>
                            <a class="dropdown-item d-none" href="javascript:void(0)">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/notification.png')}}">
                                Notification
                            </a>
                            <a class="dropdown-item d-none" href="javascript:void(0)">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/payment.png')}}">
                                Payment
                            </a>
                            <a class="dropdown-item" href="{{route('shipping-delivery-setting')}}">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/shipping.png')}}">
                                Shipping & Delivery
                            </a>
                            <a class="dropdown-item" href="{{route('user-setting')}}">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/userules.png')}}">
                                User Roles & Permission
                            </a>
                            <a class="dropdown-item" href="{{route('general-setting-store')}}">
                                <img alt="" class="store-dropico" src="{{asset('business_assets/images/store.png')}}">
                                Store Setting
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
