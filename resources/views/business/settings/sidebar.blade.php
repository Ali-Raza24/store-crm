<div class="col-lg-4">
    <div class="card-repeat profile-adder pb-5 mt-4">
        <div class="col">
            <h3 class="dark-one dark-color">Logo</h3>
        </div>
        <div class="d-flex justify-content-between" style="height: 250px">
            <div class="profile-settings">
                <img alt="" id="logoPreview"
                     @if(\App\Helpers\CommonHelper::userLogo('logo'))
                     src="{{\App\Helpers\CommonHelper::userLogo('logo')}}"
                     @else
                     src="{{asset('admin_assets/images/logo-social-round.png')}}"
                        @endif
                >
                @if(plan_has_permission(['update-logo']))
                    <a href="javascript:void(0)" data-preview="#logoPreview"
                       data-url="{{route('general-setting-store-update')}}"
                       data-form-data='@json(['business_id' => $business->id])'
                       data-name="images[logo]"
                       data-field-name="logo"
                       data-width="512"
                       data-height="512"
                       data-url-json="{{route('update-cropped-image')}}"
                       class="profile-add" data-toggle="fileupload" data-modal-title="Upload Logo">+</a>
                @endif
                <span class="logo-title">Web Logo</span>
            </div>
            <div class="profile-settings border-radius-0">
                <img alt="" id="logoPreviewMobile" class="border-radius-0"
                     @if(\App\Helpers\CommonHelper::userLogo('logo_mobile'))
                     src="{{\App\Helpers\CommonHelper::userLogo('logo_mobile')}}"
                     @else
                     src="{{asset('admin_assets/images/logo-social-round.png')}}"
                        @endif
                >
                @if(plan_has_permission(['update-logo']))
                    <a href="javascript:void(0)" data-preview="#logoPreviewMobile"
                       data-url="{{route('general-setting-store-update')}}"
                       data-url-json="{{route('update-cropped-image')}}"
                       data-form-data='@json(['business_id' => $business->id])'
                       data-name="images[logo_mobile]"
                       data-field-name="logo_mobile"
                       data-width="140"
                       data-height="35"
                       class="profile-add" data-toggle="fileupload" data-modal-title="Upload Logo">+</a>
                @endif
                <span class="logo-title">Mobile Logo</span>
            </div>
        </div>
        <p class="profile-name dark-one font-weight-700 mb-3 text-center">{{Auth::user()->business->name}}</p>
{{--        <p class="dark-two profile-tagline text-center">{{Auth::user()->business->name}}</p>--}}
        <div class="setting-planer text-center mb-3">
            {{--<a href="javascript:void(0)" class="btn-gray-light btn-rounded font-weight-600 mb-2">
                Your are using a {{$business->plan->title}} plan</a>--}}
            <p class="font-weight-600 mb-2">
                Your are using a {{$business->plan->title}} plan</p>
            @if(plan_has_permission('change-plan'))
                <a href="{{route('upgrade-subscription')}}" class="btn-gray-light btn-rounded font-weight-600 mb-2 ml-2"> Change Plan </a>
            @endif
        </div>
        <ul class="setting-generals-list mb-5">
            @if(plan_has_permission(['store-info', 'eid-and-trade-license', 'store-create', 'account-info', 'notification-setting', 'bank-details', 'checkout-setting', 'payment-setting']))
                <li>
                    <a href="@if(!Route::is('general-setting-store')){{route('general-setting-store')}}@else#@endif"
                       class="dark-one {{ request()->is('store-admin/settings/general*') ? 'active' : ''}}"> General</a>
                </li>
            @endif
            @if(plan_permission('page') || plan_permission('announcement'))
                <li>
                    @if(plan_permission('page'))
                    <a href="@if(!Route::is('business-page-setting')){{route('business-page-setting')}}@else#@endif"
                       class="dark-one {{ request()->routeIs('business-page-edit') ? 'active' : ''}}{{ request()->routeIs('business-page-setting') ? 'active' : ''}}">
                        Pages</a>
                    @else
                        <a href="@if(!Route::is('announcements.index')){{route('announcements.index')}}@else#@endif"
                           class="dark-one {{ request()->routeIs('announcements') ? 'active' : ''}}{{ request()->routeIs('announcements') ? 'active' : ''}}">
                            Announcements</a>
                    @endif
                </li>
            @endif
            @if(plan_permission('addon') || plan_permission('brand') || plan_permission('category'))
                <li>
                    <a href="@if(!Route::is('product-setting')){{route('product-setting')}}@else#@endif"
                       class="dark-one {{ request()->routeIs('product-setting') ? 'active' : ''}}"> Product Settings</a>
                </li>
            @endif
                <?php
                $optionValues = array_column($selectedPlanOptions->toArray(),'values');
                $optionsList = [];
                foreach ($optionValues as $value){
                    $seprated = explode(',', $value);
                    if (count($seprated) > 1) {
                        foreach ($seprated as $item) {
                            $optionsList[] = $item;
                        }
                    }else{
                        $optionsList[] = $value;
                    }
                }
                ?>
                @if(\App\Helpers\ArrayHelper::hasAnyValues($optionsList, ['delivery']))
            @if(plan_has_permission('shipping-general') || plan_has_permission('shipping-areas') || plan_permission('zone'))
                <li>
                    <a href="@if(!Route::is('shipping-delivery-setting')){{route('shipping-delivery-setting')}}@else#@endif"
                       class="dark-one {{ request()->routeIs('shipping-delivery-setting') ? 'active' : ''}}"> Shipping &
                        Delivery</a>
                </li>
            @endif
                @endif
            @if(plan_permission('user') || plan_permission('role'))
                <li>
                    @if(plan_permission('user'))
                        <a href="@if(!Route::is('user-list')){{route('user-list')}}@else#@endif"
                           class="dark-one {{ request()->is('*user*') || request()->is('*role*') ? 'active' : ''}}"> Users
                            Management</a>
                    @else
                        <a href="@if(!Route::is('role-list')){{route('role-list')}}@else#@endif"
                           class="dark-one {{ request()->is('*role*') || request()->is('*role*') ? 'active' : ''}}"> Roles</a>
                    @endif
                </li>
            @endif
        </ul>
        <div class="form-group ml-3 mr-3 text-center">
            <div class="input-group sm-radius-control common-input">
                <input type="text" class="form-control" id="store-url" value="{{config('urls.store_url')}}/{{Auth::user()->business->url}}" readonly>
                <a href="javascript:void(0)" class="clipboard-btn primary-text font-weight-600 common-input-btn" data-clipboard-action="copy" data-clipboard-target="#store-url">
                    Copy</a>
            </div>
            <a href="{{config('urls.store_url')}}/{{Auth::user()->business->url}}" target="_blank" class="btn-size btn-rounded btn-gray w-75 mt-3"> View
                Store</a>
        </div>

    </div>
</div>
