@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading', $business->stores()->count('id').' Stores Found')--}}

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/kartik-fileupload/css/fileinput.min.css')}}"/>
<style>
.cursor-pointer{
    cursor: pointer;
}
.input-group.file-caption-main {
    display: none;
}
</style>
@endsection

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.general.navbar')
                <hr class="m-0">
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settStore" role="tabpanel"
                         aria-labelledby="settStore">
                        <div class="col-12">
                            @include("flash::message")
                        </div>
{{--                        @if($store->is_active == \App\Constants\IStatus::ACTIVE)--}}
                        <div class="col-12 px-5">
                            @if(plan_has_permission(['eid-and-trade-license']))
                            <div class="row">
                                <div class="col-6">
                                    <label for="">National ID of the Owner</label>
                                    <div class="form-group mb-4" id="eid_business">
                                        <input type="file" class="file-upload" name="images[eid]">
                                        <a class="upload-btner dark-one" href="javascript:void(0)">National ID of the Owner</a>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <lable>Trade License</lable>
                                    <div class="form-group mb-4" id="trade_business">
                                        <input type="file" class="file-upload" name="images[trade]">
                                        <a class="dark-one upload-btner" href="javascript:void(0)">Upload Trade License</a>
                                    </div>
                                </div>
                            </div>
                                @endif
                        </div>
                            {!! Form::open(['url' => url()->current(), 'files' => true, 'id' => 'store-form']) !!}
                            {{method_field('PUT')}}
                            {!! Form::hidden('business_id',Auth::user()->business_id) !!}
                            {!! Form::hidden('stores[0][store_id]',optional($store)->id) !!}
                                <div class="row">
                                    <h4 class="col-sm-12 font-weight-700 dark-one mt-5 mb-2">Store Information</h4>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Store Name</label>
                                        {!! Form::text('stores[0][name]',$store->name,['class' => 'form-control order-edit-control']) !!}
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Business Type</label>
                                        {!! Form::text('business_type_id_',optional($business->businessType)->title,['class' => 'form-control order-edit-control', 'readonly']) !!}
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Email</label>
                                        {!! Form::email('stores[0][email]',$store->email,['class' => 'form-control order-edit-control '.($errors->has('stores.0.email') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.email')
                                            <div class="input-info bg-danger">
                                                <p>{{$message}}</p>
                                            </div>
                                        @enderror
                                    </div>
                                    {{--<div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 mb-2 dark-one">Plan Type</label>
                                        <div class="form-icon">
                                            {!! Form::select('plan_id', \App\Helpers\CommonHelper::plans(), $business->plan_id, ['class' => 'order-edit-control form-control']) !!}
                                            <span>
                                                <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                            </span>
                                        </div>
                                    </div>--}}
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Phone</label>
                                        {!! Form::number('stores[0][phone]', $store->phone, ['class' => 'form-control order-edit-control '.($errors->has('stores.0.phone') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.phone')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Mobile</label>
                                        {!! Form::number('stores[0][mobile]', $store->mobile, ['class' => 'form-control order-edit-control '.($errors->has('stores.0.mobile') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.mobile')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 mb-2 dark-one">Store Industry </label>
                                        <div class="form-icon">
                                            {!! Form::select('stores[0][industry_id]', \App\Helpers\CommonHelper::industries(), $store->industry_id, ['class' => 'order-edit-control form-control '.($errors->has('stores.0.industry_id') ? 'border-danger' : '')]) !!}
                                            @error('stores.0.industry_id')
                                            <div class="input-info bg-danger">
                                                <p>{{$message}}</p>
                                            </div>
                                            @enderror
                                            <span>
                                                <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                            </span>
                                        </div>
                                    </div>
                                    {{--<div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 mb-2 dark-one">Store Url</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">{{config('urls.store_url')}}</span>
                                            </div>
                                            {!! Form::text('url', $business->url, ['class' => 'order-edit-control form-control '.($errors->has('url') ? 'border-danger' : ''), 'disabled']) !!}
                                            @error('url')
                                            <div class="input-info bg-danger">
                                                <p>{{$message}}</p>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>--}}
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 mb-2 dark-one">Country</label>
                                        <div class="form-icon">
                                            {!! Form::select('stores[0][country_id]', \App\Helpers\CommonHelper::countries(), $store->country_id, ['class' => 'order-edit-control form-control '.($errors->has('stores.0.country_id') ? 'border-danger' : '')]) !!}
                                            @error('stores.0.country_id')
                                            <div class="input-info bg-danger">
                                                <p>{{$message}}</p>
                                            </div>
                                            @enderror
                                            <span>
                                                <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 mb-2 dark-one">City</label>
                                        <div class="form-icon">
                                            {!! Form::select('stores[0][state_id]', \App\Helpers\CommonHelper::states(), $store->state_id, ['class' => 'order-edit-control form-control '.($errors->has('stores.0.state_id') ? 'border-danger' : '')]) !!}
                                            @error('stores.0.state_id')
                                            <div class="input-info bg-danger">
                                                <p>{{$message}}</p>
                                            </div>
                                            @enderror
                                            <span>
                                                <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Address 1</label>
                                        {!! Form::text('stores[0][address_1]', $store->address_1, ['class' => 'form-control order-edit-control '.($errors->has('stores.0.address_1') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.address_1')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Address 2</label>
                                        {!! Form::text('stores[0][address_2]', $store->address_2, ['class' => 'form-control order-edit-control '.($errors->has('stores.0.address_2') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.address_2')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Brand Color</label>
                                        {!! Form::color('brand_color', isset($business->brand_color) ? $business->brand_color : '#ffffff', ['class' => 'form-control order-edit-control '.($errors->has('brand_color') ? 'border-danger' : '')]) !!}
                                        @error('brand_color')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Delivery Limit (KM)</label>
                                        {!! Form::number('stores[0][delivery_limit_km]', $store->delivery_limit_km, ['class' => 'form-control order-edit-control '.($errors->has('stores.0.delivery_limit_km') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.delivery_limit_km')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Opening time</label>
                                        {!! Form::time('stores[0][opening_time]', $store->opening_time, ['class' => 'form-control order-edit-control '.($errors->has('stores.0.opening_time') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.opening_time')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-group mb-3">
                                        <label class="font-weight-600 dark-one">Closing Time</label>
                                        {!! Form::time('stores[0][closing_time]', $store->closing_time, ['class' => 'form-control order-edit-control '.($errors->has('stores.0.closing_time') ? 'border-danger' : '')]) !!}
                                        @error('stores.0.closing_time')
                                        <div class="input-info bg-danger">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mt-4">
                                            <div class="d-flex justify-content-between">
                                                <label class="font-weight-600 mb-2 dark-one">All Stores</label>
                                                @if(plan_has_permission(['store-create']))
                                                <div>
                                                    <a href="{{route('store-create')}}" class="btn-underline primary-text">
                                                        + Create New Store
                                                    </a>
                                                </div>
                                                    @endif
                                            </div>
                                            <input type="hidden">
                                            <div class=" table-responsive scroll-bar-thin location-group sm-radius-control">
                                                <table class="table m-0">
                                                    <tbody>
                                                    @foreach($business->stores as $business_store)
                                                        <tr>
                                                            <td>
                                                                <span class="dark-one">{{$business_store->name}} @if((session()->get('store-data'))['slug'] == $business_store->slug) (current) @endif</span>
                                                            </td>
                                                            <td>
                                                                <span class="dark-one">{{optional($business_store->state)->name}}</span>
                                                            </td>
                                                            <td class="store-activator text-center">
                                                                <a href="{{route('change-store', ['name' => $business_store->slug])}}" class="btn btn-default btn-sm">
                                                                    <img alt="" src="{{asset('business_assets/images/edit1.png')}}" title="Edit store" data-toggle="tooltip" data-placement="bottom">
                                                                </a>
                                                                <div class="custom-control custom-switch custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" id="storeSwitch{{$loop->iteration}}" onchange="updateStore(this, {{$business_store->id}})" @if($business_store->is_active == \App\Constants\IStatus::ACTIVE) checked @endif>
                                                                    <label class="custom-control-label" for="storeSwitch{{$loop->iteration}}"></label>
                                                                </div>
                                                                @if($business_store->is_active == \App\Constants\IStatus::ACTIVE)
                                                                    <span class="delete-rcd d-none" data-toggle="modal" id="status{{$business_store->id}}"
                                                                          title="Inactive store"
                                                                          data-title="Inactive"
                                                                          data-id="{{$business_store->id}}"
                                                                          data-target="#delStore"
                                                                          data-modal="modal"
                                                                    >
                                                                        <img alt="" src="{{asset('business_assets/images/delete.png')}}">
                                                                    </span>
                                                                @else
                                                                    <a href="#" class="primary-text d-none" id="status{{$business_store->id}}" data-toggle="modal"
                                                                       title="Active store"
                                                                       data-modal="modal"
                                                                       data-title="Active"
                                                                       data-target="#delStore"
                                                                       data-id="{{$business_store->id}}"
                                                                    >
                                                                        Live Again
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="form-group mb-0 text-right">
                                <hr class="mt-5 mb-3">
                                <button
                                        id="update-button"
                                   class="btn-size btn-rounded btn-primary mr-3">
                                    Update
                                </button>
                            </div>
                            {!! Form::close() !!}
                        {{--@else

                            <div class="col-12 ml-3">
                                <a href="#" class="btn btn-primary fa-1x text-white" data-toggle="modal"
                                   title="Active store"
                                   data-modal="modal"
                                   data-title="Live"
                                   data-target="#delStore"
                                   data-id="{{optional($store)->id}}"
                                >
                                    Please Click here to active this store
                                </a>
                            </div>
                        @endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extras')
    <div class="modal fade refund-modal" id="delStore" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    {!! Form::open(['route' => 'store-status']) !!}
                    {!! method_field('put') !!}
                    <input type="hidden" name="store_id" id="store_id">
                    <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> Store?</h2>
                    <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Delete</span> this store?</h4>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal" data-action="cancel">
                        Cancel </a>
                    <button class="btn-size btn-rounded btn-primary ml-1 mr-1" ><span data-modal-title="title">Delete</span></button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('layouts.jquery')
    <script src="{{asset('plugins/kartik-fileupload/js/fileinput.min.js')}}"></script>
    <script src="{{asset('plugins/kartik-fileupload/themes/fas/theme.min.js')}}"></script>

    <script>
        $(function(){
          var eid = '{{$business->eid}}';
          var eidInfo = eid.split('/');
          eidInfo = eidInfo[eidInfo.length - 1]
          eidInfo = eidInfo.split('.')

          var trade = '{{$business->trade}}';
          var tradeInfo = trade.split('/');
          tradeInfo = tradeInfo[tradeInfo.length - 1]
          tradeInfo = tradeInfo.split('.')

          $('[name="images[eid]"]').fileinput({
            theme:'fas',
            uploadUrl: "{{route('general-setting-store-update')}}",
            uploadExtraData: {_token:"{{csrf_token()}}", 'business_id': {{$business->id}}, "eid_upload": true},
            allowedFileExtensions:['png', 'jpg', 'pdf'],
            @if($business->eid)
            initialPreview: [eid],
            initialPreviewAsData: true,
            initialPreviewConfig: [
              eidInfo[1] === 'pdf' ?
                {caption: eidInfo, filename: eidInfo, width: "120px", key: 2, type: eidInfo[1]} :
                {caption: eidInfo, filename: eidInfo, width: "120px", key: 2}
            ],
            @endif
            showRemove:false,
            browseOnZoneClick: true,
            dropZoneTitle: 'Drop or Click to Upload National ID',
            dropZoneClickTitle: '',
            showUpload:false,
            autoReplace: true,
            maxFileCount: 1,
            overwriteInitial: true,
          }).on("filebatchselected", function(event, files) {
            $('[name="images[eid]"]').fileinput("upload");
          }).on('fileselect', function() {
            $('#eid_business .file-preview-success').remove();
          });
          $('[name="images[trade]"]').fileinput({
            theme:'fas',
            allowedFileExtensions:['png', 'jpg', 'pdf'],
            uploadUrl: "{{route('general-setting-store-update')}}",
            uploadExtraData: {_token:"{{csrf_token()}}", 'business_id': {{$business->id}}, "trade_upload": true},
            @if($business->trade)
            initialPreview: [trade],
            initialPreviewAsData: true,
            initialPreviewConfig: [
              tradeInfo[1] === 'pdf' ?
                {caption: tradeInfo, filename: tradeInfo, width: "120px", key: 2, type: tradeInfo[1]} :
                {caption: tradeInfo, filename: tradeInfo, width: "120px", key: 2}
            ],
            @endif
            uploadAsync: true,
            showRemove:false,
            browseOnZoneClick: true,
            dropZoneTitle: 'Drop or Click to Upload Trade license',
            dropZoneClickTitle: '',
            showUpload:false,
            autoReplace: true,
            maxFileCount: 1,
            overwriteInitial: true,
          }).on("filebatchselected", function(event, files) {
            $('[name="images[trade]"]').fileinput("upload");
          }).on('fileselect', function() {
            $('#trade_business .file-preview-success').remove();
          })
        })
    </script>
    <script>
        $('[data-modal="modal"]').on('click', function(){
            $('#store_id').val($(this).data('id'));
            $('[data-modal-title="title"]').text($(this).data('title'))
        });
    </script>
    <script>
      function updateStore($object, id){
        $('#status'+id).trigger('click');
      }
      $('[data-action="cancel"]').on('click', function() {
        let $id = $('#store_id').val();
        $('#storeSwitch'+$id).prop("checked", !$('#storeSwitch'+$id).prop("checked"));
      })

      $(document).ready(function() {

        $('#store-form input',document).bind(
          "change", function() {
            window.onbeforeunload = function() {
              return 'You have unsaved changes!';
            }
          }
        ); // Prevent accidental navigation away

        $('#update-button').on('click', function(){
          window.onbeforeunload = false;
        })

      });
    </script>
@endsection
