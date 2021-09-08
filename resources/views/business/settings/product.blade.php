@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general mt-4">
                <div id="settings">
                    <product-setting
                            brand_status_change_url="{{api_url('brand_Status_change_url')}}"
                            get_all_brands_url="{{api_url('allbrands')}}"
                            edit_brand_url="{{api_url('edit_url')}}"
                            add_brand_url="{{api_url('add_brand')}}"
                            delete_brand_url="{{api_url('delete_url')}}"
                            brands_status_change_confirmation_url="{{api_url('brands_status_change_confirmation_url')}}"
                            delete_brands_popup_confirmation_url="{{api_url('delete_brands_popup_confirmation_url')}}"
                            :brand_permission="{{plan_permission('brand') == true ? 'true' : 'false'}}"
                            :brand_permissions="{{json_encode(Auth::user()->business->plan->role->permissions()->where('name','like','%brand-%')->pluck('name')->toArray())}}"
                            :addon_permission="{{plan_permission('addon') == true ? 'true' : 'false'}}"
                            :addon_permissions="{{json_encode(Auth::user()->business->plan->role->permissions()->where('name','like','%addon-%')->pluck('name')->toArray())}}"
                            :category_permission="{{plan_permission('category') == true ? 'true' : 'false'}}"
                            :category_permissions="{{json_encode(Auth::user()->business->plan->role->permissions()->where('name','like','%category-%')->pluck('name')->toArray())}}"

                            get_all_addons="{{api_url('all_addons')}}"
                            edit_addon_url="{{api_url('edit_addon_url')}}"
                            add_addon_url="{{api_url('add_addon_url')}}"
                            delete_addon_url="{{api_url('delete_addon_url')}}"
                            addon_status_update_url="{{api_url('addon_status_update_url')}}"
                            bulk_addons_status_change="{{api_url('bulk_addons_status_change')}}"
                            delete_addons_popup_confirmation_url="{{api_url('delete_addons_popup_confirmation_url')}}"

                            get_all_categories="{{api_url('all_categories')}}"
                            edit_category_url="{{api_url('edit_category_url')}}"
                            add_category_url="{{api_url('add_category_url')}}"
                            delete_category_url="{{api_url('delete_category_url')}}"
                            category_status_update_url="{{api_url('category_status_update_url')}}"
                            delete_categories_popup_confirmation_url="{{api_url('delete_categories_popup_confirmation_url')}}"
                            bulk_categories_status_change="{{api_url('bulk_categories_status_change')}}"
                    ></product-setting>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@endsection

@section('extras')
@endsection

@section('scripts')
    <script src="{{asset_timestamp('js/settings.js')}}"></script>
    <scrtipt src="{{asset('admin_assets/js/select2.min.js')}}"></scrtipt>
@endsection
