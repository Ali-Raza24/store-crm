@extends('layouts.business.app')

@section('stylesheet')
    <link rel="stylesheet" href="{{asset('business_assets/css/customer.css')}}">
@endsection

@section('title','All Products')

@section('header_heading', "All Products")

{{--@section("header_subheading", "$totalProducts Products Found")--}}

@section('css')

    <style>
        .variant-table td, .variant-table thead tr{
            border-bottom: none !important;
        }

        .variant-table:nth-child(4){
            border-bottom: 1px solid;
        }
        .variant-table td, .variant-table th{
            padding: 0.5rem !important;
        }
        .variant-table .container, .variant-table input{
            display: inline-block !important;
        }
    </style>

@endsection

@section('content')
    <div class="row counter-wrapp scroller-h">
        <x-counter-box column="4" border_color="primary" text_color="primary" title="Total Discount" total="{{$discountCount}}"
                       class="mt-lg-4 mt-3"/>
        <x-counter-box column="4" border_color="green" text_color="green" title="Number Of Brands" total="{{$totalBrands}}"
                       class="mt-lg-4 mt-3"/>
        <x-counter-box column="4" border_color="lightblue" text_color="lightblue" title="Total Amount " total="{{$totalAmount}}"
                       class="mt-lg-4 mt-3"/>
    </div>
    @include('business.products.navbar')
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="AllProducts" role="tabpanel" aria-labelledby="AllProducts">
            <div class="mt-3">
                @include('flash::message')
            </div>
            @include('business.products.table')
        </div>
    </div>

@endsection

@section('footer')
    <div class="selected-item-panel">
        <div class="selected-item">
            <ul class="selected-list">
                <li>
                    <div class="item-show">
                        <span>
                            <img src="{{asset('business_assets/images/close-wgite.png')}}" alt="image" />
                        </span>
                        <p class="mobile-hide"><span id="totalSelected">0</span> <span class="bg-transparent" id="selectCountText">Item</span> Selected</p>
                    </div>
                </li>
                @if(plan_has_permission(['product-bulk-status']))
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('product-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Active this product"
                       data-id="bulk"
                    >
                        <span>Active</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('product-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Inactivate this product"
                       data-id="bulk"
                    >
                        <span>InActive</span>
                    </a>
                </li>
                @endif
                @if(plan_has_permission(['product-bulk-delete']))
                <li>
                    <a href="javascript:void(0)" class="item-btn export-option"
                       data-toggle="modal"
                       data-url="{{route('product-bulk-delete')}}"
                       data-modal="modal"
                       data-type="delete"
                       data-target="#confirmModal"
                       data-title="Delete this product"
                       data-id="bulk"
                    >
                        <span>Delete</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
@endsection

@section('extras')
    @include('business.products.extra')
    @include('business.products.add')
@endsection

@section('scripts')
    <script src="{{asset_timestamp('js/product.js')}}"></script>
    <script src="{{asset('admin_assets/js/select2.min.js')}}"></script>
@endsection
@section('custom_script')
    @if($errors->any())
        <script>
            $('body').toggleClass('add-customer')
            $('body').toggleClass('all-product')
        </script>
    @endif
    <script>
      let ids = [];
      $('[data-modal="modal"]').on('click', function(){
        if ($(this).data('id') === 'bulk'){
          $.each($('.list-check:checked'), function(){
            ids.push($(this).val())
          })
          $('#product_id').val(ids)
        } else {
          $('#product_id').val($(this).data('id'));
        }
        $('#status_id').val($(this).data('status'));
        $('[data-modal-title="title"]').text($(this).data('title'))
        $('#confirmForm').attr('action',$(this).data('url'))
        $('#method').val($(this).data('type'))
        $
      });

      $('#checkAll').on('change',function(){
        if ($(this).is(':checked')){
          $('.list-check').prop('checked', true)
        }else{
          $('.list-check').prop('checked', false)
        }
        $('#totalSelected').text($('.list-check:checked').length)

        if ($('.list-check:checked').length > 1){
          $('#selectCountText').text('Items')

          $('[data-id="bulk"]').each(function() {
            let $title = $(this).data('title');
            let $titleArr = $title.split(' ');
            $(this).data('title',$titleArr[0] + ' these products')
          })

        }else{
          $('#selectCountText').text('Item')

          $('[data-id="bulk"]').each(function() {
            let $title = $(this).data('title');
            let $titleArr = $title.split(' ');
            $(this).data('title',$titleArr[0] + ' this product')
          })
        }

      })
      $(function(){
        $('.list-check').on('change', function(){
          if($('.list-check:checked').length === $('.list-check').length){
            $('#checkAll').prop('checked', true)
          }else{
            $('#checkAll').prop('checked', false)
          }
          $('#totalSelected').text($('.list-check:checked').length)

          if ($('.list-check:checked').length > 1){
            $('#selectCountText').text('Items')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' these products')
            })
          }else{
            $('#selectCountText').text('Item')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' this product')
            })
          }
        })
      })


      function calculate(){
        let $costPrice = $('#cost-price');
        let $retailPrice = $('#retail-price');
        let $discountedPrice = $('#discounted-price');
        let $margin = $('#product_margin');
        let $profit = $('#product_profit');

        let $retailPriceVal = $retailPrice.val();
        let $discountedPriceVal = $discountedPrice.val();
        let $costPriceVal = $costPrice.val();
        let $marginValue = 0;
        let $profitValue = 0;

        if (parseFloat($discountedPriceVal) > 0){
          $profitValue = (parseFloat($discountedPriceVal) - parseFloat($costPriceVal));
          $marginValue = ($profitValue/$costPriceVal) * 100;
        }else{
          $profitValue = (parseFloat($retailPriceVal) - parseFloat($costPriceVal));
          $marginValue = ($profitValue/$costPriceVal) * 100;
        }
        $margin.text(formatValue($marginValue) + ' %')
        $profit.text(formatValue($profitValue) + ' AED')
      }
    </script>

    <script>
        $(document).on('change', '[data-upload="image"]', function() {
          var fieldName = $(this).prop('name');
          var file = this.files[0];
          var formData = new FormData();
          formData.append(fieldName, file);
          $.ajax({
            // Your server script to process the upload
            url: '{{route('product-image-validate')}}',
            type: 'POST',

            // Form data
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
              $('#'+data.key).closest('span').removeClass('text-danger').text('')
            },
            error:function(error, data){
                Object.keys(error.responseJSON.errors).map(key => {
                  let message = error.responseJSON.errors[key][0];
                  let id = key.replaceAll('.','-');
                  $('#'+id).closest('span').addClass('text-danger').text(message)
                })
            }
          });
        })

        $(function() {
          $(document).on('change', '#product-title', function() {
            let $val = $(this).val();

            $('#slug').val($val.replaceAll(/[^a-zA-Z0-9]/g, '-').toLowerCase())
          })
        })

        $('#brand_id').select2({
          ajax: {
            url: '{{route('get-all-brands')}}',
            dataType: 'json',
            delay: 250,
            width:'resolve',
            data: function (params) {
              return {
                search: params.term
              };
            },
            processResults: function (response) {
              return {
                results: response
              };

            },
            cache: true
          }
        });

        $('#categories').select2({
          ajax: {
            url: '{{route('get-all-categories')}}',
            dataType: 'json',
            delay: 250,
            width:'resolve',
            data: function (params) {
              return {
                search: params.term
              };
            },
            processResults: function (response) {
              return {
                results: response
              };

            },
            cache: true
          }
        });

        $(function(){
          $(document).on('click','[data-form="add"]', function() {
            $('#categoryForm').find('.alert-success').remove()
            $('#brandForm').find('.alert-success').remove()

            $('#categoryForm').find('input, select').val('').removeClass('is-valid').removeClass('danger-border')
            $('#brandForm').find('input, select').val('').removeClass('is-valid').removeClass('danger-border')
          })
        })
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    {!! \Proengsoft\JsValidation\Facades\JsValidatorFacade::formRequest('App\Http\Requests\ProductRequest', '#add-product-form') !!}


    {!! \Proengsoft\JsValidation\Facades\JsValidatorFacade::formRequest('App\Http\Requests\AddBrand', '#brandForm') !!}
    {!! \Proengsoft\JsValidation\Facades\JsValidatorFacade::formRequest('App\Http\Requests\AddCategory', '#categoryForm') !!}
@endsection
