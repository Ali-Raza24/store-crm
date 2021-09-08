@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('css')
    <style>
        .pac-container {
            top: 200px !important;
            z-index: 100000;
        }
    </style>
@endsection

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')

        <?php
        $store = session()->get('store-data');
        $storeId = 0;
        if (!empty($store)){
            $storeId = $store->id;
        }
        ?>
        <div id="areas" class="col-lg-8">
            <Areas
                    states_url="{{api_url('states-list')}}"
                    save_area_url="{{api_url('save_area_url')}}"
                    get_areas="{{api_url('get_areas')}}"
                    get_business_areas="{{api_url('get_business_areas')}}"
                    get_stores="{{api_url('stores-list')}}"
                    save_business_areas="{{api_url('save_business_areas')}}"
                    save_zone_url="{{api_url('save_zone_url')}}"
                    get_zone_url="{{api_url('get_zone_url')}}"
                    get_active_area="{{api_url('get_active_area')}}"
                    save_zone_areas="{{api_url('save_zone_areas')}}"
                    get_active_zone_areas="{{api_url('get_active_zone_areas')}}"
                    update_delivery_type="{{api_url('update_delivery_type')}}"
                    get_delivery_type="{{api_url('get_delivery_type')}}"
                    get_delivery_store="{{api_url('get_delivery_store')}}"
                    get_delivery_companies="{{api_url('get-delivery-companies')}}"
                    delete_area_url="{{api_url('delete_area_url')}}"
                    delete_zone_url="{{api_url('delete_zone_url')}}"
                    get_area_by_id="{{api_url('get_area_by_id')}}"
                    get_zone_by_id="{{api_url('get_zone_by_id')}}"
                    store_id="{{$storeId}}"
                    :business_zone_count="{{\Auth::user()->business->businessZones()->count('id')}}"
                    save_store_locations_url="{{api_url('save_store_locations_url')}}"
                    get_store_by_id="{{api_url('get_store')}}"
                    :zone_permission="{{plan_has_permission(['zone-areas']) == 1 ? 'true' : 'false'}}"
                    :zone_permissions="{{json_encode(Auth::user()->business->plan->role->permissions()->where('name','like','%zone-%')->pluck('name')->toArray())}}"
                    :store_delivery_permission="{{plan_has_permission(['shipping-general']) == true ? 'true': 'false'}}"
                    :shipping_areas_permission="{{plan_has_permission(['shipping-areas']) == true ? 'true': 'false'}}"
            ></Areas>
        </div>
        <div class="body-overlay"></div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset_timestamp('js/areas.js')}}"></script>
    <script src="{{asset('admin_assets/js/select2.min.js')}}"></script>
@endsection
