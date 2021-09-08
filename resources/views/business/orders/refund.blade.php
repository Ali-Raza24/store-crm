@extends('layouts.business.app')

@section('title','Order Detail')

@section('header_heading', "Order Detail")

@section("header_subheading", "")

@section('content')
    <header class="web-header center-header-heading" style="height: 120px;">
        <div class="container-fluid">
            <div class="mobile-header">
                    <span class="sidebar-toggle">
                        <i></i> <i></i> <i></i>
                    </span>
                <img alt="" src="{{asset('images/yabee_logo_1.png')}}" class="mobile-brand">
                <div class="mobile-metas">
                    <a href="javascript:void(0)" class="notification-page">
                        <img alt="" src="{{asset('business_assets/images/notification.png')}}">
                        <span class="bege">3</span>
                    </a>
                    <span class="header-meta-collapse">
                            <i></i> <i></i> <i></i>
                        </span>
                </div>
            </div>
            <div class="header-flexer">
                <div class="header-lefter mobile-hide">
                </div>
                <div class="col text-center">
                    <h3 class="dark-one font-weight-700 mb-2">Order #{{$order->id}}</h3>
                </div>
                <div class="header-metas">
                    <div class="dropdown dropdown-stores">
                        <button class="dropdown-toggle" type="button" id="dropStore" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <?php $store = session()->get('store-data');?>
                            @if($store->is_active == \App\Constants\IStatus::DISABLE)
                                <span class="lg-show text-danger">{{session()->get('store-name')}} (InActive)</span>
                            @else
                                <span class="lg-show">{{session()->get('store-name')}}</span>
                            @endif
                            <span class="sm-show"> Al Jazzat - Sharjah - United Arab Emirates</span>
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
                        <a href="{{route('general-setting-store')}}" class="setting-page">
                            <img alt="" src="{{asset('business_assets/images/setting.png')}}">
                        </a>
                        <a href="javascript:void(0)" class="notification-page mobile-hide">
                            <img alt="" src="{{asset('business_assets/images/notification.png')}}">
                            <span class="bege">3</span>
                        </a>
                        <div class="dropdown dropdown-profile">
                            <button class="dropdown-toggle" type="button" id="dropProfile" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <img alt="" src="{{asset('business_assets/images/profile.png')}}">
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
    <div class="row">
        <div class="col">
            <div class="refund-success mt-5">
                <h2 class="dark-one font-weight-700 mb-4 text-center">Amount Refunded </h2>
                <div class="refund-badge">
                    <span> <img alt="" src="{{asset('business_assets/images/check.png')}}"> </span>
                    <h4 class="dark-one font-weight-500">Amount Refunded Successfully</h4>
                </div>
                <div class="refund-badge mt-3">
                    <span> <img alt="" src="{{asset('business_assets/images/check.png')}}"> </span>
                    <h4 class="dark-one font-weight-500">Receipt / Email Sent</h4>
                </div>
                <div class="text-center">
                    <a href="{{route('orders-list')}}" class="btn-size btn-rounded btn-primary mt-4"> Back To Order </a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
@endsection
