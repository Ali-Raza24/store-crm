@extends('layouts.business.app')

@section('title','Product')

@section('header_heading', "Product")

@section("header_subheading", "")

@section('content')
    <style>
        #productExtra #variants > table, td {
            border: 0 !important;
        }

        #productExtra #variants > tr {
            border-bottom: 1px solid #CDDEEB !important;
        }
    </style>
    @php
    /**
    * @var $product \App\Models\Product
    *
    **/
    @endphp
    <div class="card-repeat product-wrapp">
        {!! Form::model($product, ['route' => 'product-store', 'files' => true, 'id' => 'edit-product-form']) !!}
        {!! Form::hidden('product_id', $product->id) !!}

        @include('flash::message')
        <div class="row">
            <div class="col-lg-6">
                <div id="mobile-images" class="d-lg-none">
                </div>
                <div class="product-infos" id="">
                    <div class="d-flex justify-content-between">
                        <h4 class="dark-one font-weight-700 mb-4">Product Information</h4>
                        <a href="{{config('urls.store_url')}}/{{$business->url}}/{{optional($product->categories()->first())->slug}}/{{$product->slug}}" class="btn-primary btn-size btn-rounded" target="_blank">View Product</a>
                    </div>

                    <hr>
                    <div class="form-group mb-4">
                        <div class="col ml-2">
                            <input type="checkbox" class="custom-control-input list-check" value="1"
                                   id=customCheck_discount @if(!$product->discount_not_allowed) checked @endif>
                            <label class="custom-control-label" for="customCheck_discount"><h4 class="font-weight-bolder">Apply discount to this product</h4></label>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group mb-4">
                        <label class="font-weight-600 mb-2 dark-one">Product Title </label>
                        {!! Form::text('title',null, ['class' => 'order-edit-control form-control '.($errors->has('title') ? 'border-danger' :''), 'id' => 'product-title']) !!}
                        @error('title')
                        <div class="danger-bg input-info"><p>{{$message}}</p></div>
                        @enderror
                    </div>

                    <div class="form-group mt-5 discount-code d-none">
                        <label>Product Url</label>
                        <div class="input-group">
                            <span class="input-group-prepend"><span class="input-group-text bg-transparent">{Your Store Url}/</span></span>
                            {!! Form::text('slug', null, ['class' => 'order-edit-control form-control '.($errors->has('slug') ? 'border-danger' :''), 'id' => 'slug']) !!}
                        </div>
                        @error('slug')
                        <div class="danger-bg input-info"><p>{!! $message !!}</p></div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-600 mb-2 dark-one"> Description </label>
                        {!! Form::textarea('description', null, ['class' => 'order-edit-control form-control '.($errors->has('description') ? 'border-danger' :'')]) !!}
                        @error('description')
                        <div class="danger-bg input-info"><p>{{$message}}</p></div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group mb-4">
                                <div class="d-flex justify-content-between">
                                    <label class="font-weight-600 mb-2 dark-one">Brand </label>
                                    <div>
                                        {{--    <a href="javascript:void(0)" class="btn-underline primary-text"
                                               data-toggle="modal" data-target="#addNewbrand">
                                                + Add New
                                            </a>--}}
                                    </div>
                                </div>
                                <div class="form-icon">
                                    {!! Form::select('brand_id', \App\Helpers\CommonHelper::brands(), $product->brand_id, ['class' => 'order-edit-control form-control '.($errors->has('brand_id') ? 'border-danger' :'')]) !!}
                                    @error('brand_id')
                                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                    @enderror
                                    <span>
                                        <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group mb-4">
                                <div class="d-flex justify-content-between">
                                    <label class="font-weight-600 mb-2 dark-one">Category </label>
                                    <div>
                                        {{--<a href="javascript:void(0)" class="btn-underline primary-text"
                                           data-toggle="modal" data-target="#addNewcategory">
                                            + Add New
                                        </a>--}}
                                    </div>
                                </div>
                                {!! Form::select('categories[]',
                                    \App\Helpers\CommonHelper::categories(),
                                    $product->categories()->pluck('category_id'),
                                    ['class' => 'js-select2 order-edit-control form-control '.($errors->has('categories') ? 'border-danger' :''),
                                     'multiple' => true]) !!}
                                @error('categories')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-600 mb-2 dark-one">Cost Price </label>
                                {!! Form::text('cost_price',null, ['class' => 'order-edit-control form-control cost-price '.($errors->has('cost_price') ? 'border-danger' :''), 'placeholder' => 'AED 0', 'onkeyup' => 'calculate("#desktop-view")']) !!}
                                @error('cost_price')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-600 mb-2 dark-one">Retail Price </label>
                                {!! Form::text('retail_price',null, ['class' => 'order-edit-control form-control retail-price '.($errors->has('retail_price') ? 'border-danger' :''), 'placeholder' => 'AED 0', 'onkeyup' => 'calculate("#desktop-view")']) !!}
                                @error('retail_price')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group mb-4">
                                <label class="font-weight-600 mb-2 dark-one"> Discounted Price </label>
                                {!! Form::text('discounted_price',null, ['class' => 'order-edit-control form-control discounted-price '.($errors->has('discounted_price') ? 'border-danger' :''), 'placeholder' => 'AED 0', 'onkeyup' => 'calculate("#desktop-view")']) !!}
                                @error('discounted_price')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                        </div>
                        <?php
                        $retailPrice = $product->retail_price;
                        $costPrice = $product->cost_price;
                        $discount = $product->discounted_price;
                        if ($discount > 0) {
                            $profitValue = $discount - $costPrice;
                            if ($costPrice > 0){
                                $marginValue = ($profitValue / $costPrice) * 100;
                            }else{
                                $marginValue = 0;
                            }
                        } else {
                            $profitValue = $retailPrice - $costPrice;
                            if ($costPrice > 0){
                                $marginValue = ($profitValue / $costPrice) * 100;
                            }else{
                                $marginValue = 0;
                            }
                        }
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <div class="form-group mb-0">
                                    <label class="font-weight-600 mb-0 dark-one"> Margin: </label>
                                    <p class="dark-four m-0 d-inline-block product_margin">{{ $marginValue}}%</p>
                                    <input type="hidden" class="">
                                </div>
                                <div class="mb-0">
                                    <label class="font-weight-600 mb-0 dark-one"> Profit: </label>
                                    <p class="dark-four m-0 d-inline-block product_profit">{{$profitValue}} AED</p>
                                    <input type="hidden" class="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label class="font-weight-600 mb-2 dark-one">Product Availability Locations
                                </label>
                                {!! Form::select('stores[]',
                                    \App\Helpers\CommonHelper::stores()->pluck('name','id'),
                                    $product->stores()->pluck('store_id'),
                                    ['class' => 'js-select2 order-edit-control form-control '.($errors->has('stores') ? 'border-danger' :''),
                                     'multiple' => true]) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-600 mb-2 dark-one">Barcode </label>
                                {!! Form::text('barcode',null, ['class' => 'order-edit-control form-control '.($errors->has('barcode') ? 'border-danger' :''), 'placeholder' => 'Barcode']) !!}
                                @error('barcode')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-600 mb-2 dark-one">SKU </label>
                                {!! Form::text('sku',null, ['class' => 'order-edit-control form-control '.($errors->has('sku') ? 'border-danger' :''), 'placeholder' => 'Product Title']) !!}
                                @error('sku')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product-infos">
                    <div id="desktop-images">
                        {{--<div class="add-pro-thumbs mb-4 mobile-hide d-lg-flex ">
                            <div class="product-big">
                                <div class="bg-gray">
                                    <img id="main_preview"
                                         src="@if($product->main_image) {{$product->main_image}} @else {{asset('images/upload-big.png')}} @endif"
                                         alt=""
                                    >
                                </div>
                                <span class="clicker-product" data-preview="#main_preview"
                                      data-url="{{route('product-image-upload')}}"
                                      data-form-data='@json(['product_id' => $product->id])'
                                      data-name="images[main]"
                                      data-toggle="fileupload"
                                >
                                <img alt="" src="{{asset('business_assets/images/plus-round.png')}}">
                            </span>
                            </div>
                            <div class="product-small">
                                @foreach($product->other_images as $other_image)
                                    <div class="thumb-list">
                                        <img src="{!! $other_image->url !!}" id="preview{{$loop->iteration}}">

                                        <span class="clicker-product" data-preview="#preview{{$loop->iteration}}"
                                              data-url="{{route('product-image-upload')}}"
                                              data-form-data='@json(['product_id' => $product->id])'
                                              data-name="images[{{$loop->iteration}}]"
                                              data-toggle="fileupload"
                                        >
                                            <img alt="" src="{{asset('business_assets/images/plus-round.png')}}">
                                    </span>
                                    </div>
                                @endforeach
                                <?php $total = 3 - count($product->other_images); ?>
                                @for($i=0; $i < $total; $i++)
                                    <div class="thumb-list">
                                        <img src="{!! asset('images/upload-big.png') !!}"
                                             id="preview{{$i+1+count($product->other_images)}}">
                                        <span class="clicker-product"
                                              data-preview="#preview{{$i+1+count($product->other_images)}}"
                                              data-url="{{route('product-image-upload')}}"
                                              data-form-data='@json(['product_id' => $product->id])'
                                              data-name="images[{{$i+1+count($product->other_images)}}]"
                                              data-toggle="fileupload"
                                        >
                                            <img alt="" src="{{asset('business_assets/images/plus-round.png')}}">
                                    </span>
                                    </div>
                                @endfor
                            </div>
                        </div>--}}
                    </div>
                </div>
                <hr class="mt-3 mb-3">
                @if(Auth::user()->business->business_type_id == 2)
                    <h4 class="dark-one font-weight-700 mb-4">Product Variants</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="sf-order">
                                <div class="table-responsive scroll-bar-thin">
                                    <table class="table table-space table-check">
                                        <thead>
                                        <th scope="col" class="p-0"></th>
                                        <th scope="col" class="p-0">Option</th>
                                        <th scope="col" class="p-0">Cost Price</th>
                                        <th scope="col" class="p-0">Retail Price</th>
                                        <th scope="col" class="p-0">Discounted Price</th>
                                        <th scope="col" class="p-0">Barcode</th>
                                        <th scope="col" class="p-0">SKU</th>
                                        <th scope="col" class="p-0"></th>
                                        </thead>
                                        <tbody>
                                        @foreach($product->variants as $variant)
                                            <tr>
                                                <td class="custom-checkbox show-selected p-0">
                                                    <input type="checkbox" class="custom-control-input"
                                                           value="{{$variant->id}}"
                                                           name="variant_is_active[{{$variant->id}}]"
                                                           id="customCheck{{$loop->iteration + 2}}"
                                                           @if($variant->is_active) checked @endif
                                                    >
                                                    <label class="custom-control-label"
                                                           for="customCheck{{$loop->iteration + 2}}"></label>
                                                    @if($variant->images)
                                                        <img src="{{optional($variant->images)->url}}" alt=""
                                                             width="50px" height="50px"
                                                             id="variant_preview_{{$variant->id}}"
                                                             data-preview="#variant_preview_{{$variant->id}}"
                                                             data-url="{{route('variant-image-upload')}}"
                                                             data-form-data='@json(['variant' => $variant->id])'
                                                             data-name="images[{{$variant->id}}]"
                                                             data-toggle="fileupload"
                                                        >
                                                    @else
                                                        <img src="{{asset('img/camera_icon.png')}}" alt="" width="50px"
                                                             height="50px"
                                                             id="variant_preview_{{$variant->id}}"
                                                             data-preview="#variant_preview_{{$variant->id}}"
                                                             data-url="{{route('variant-image-upload')}}"
                                                             data-form-data='@json(['variant' => $variant->id])'
                                                             data-name="images[{{$variant->id}}]"
                                                             data-toggle="fileupload"
                                                        >
                                                    @endif
                                                </td>
                                                <td class="p-0">
                                                    @foreach(explode('/', $variant->title) as $title)
                                                        <input type="hidden" name="option[]" value="{{$title}}">
                                                    @endforeach
                                                    {{$variant->title}}
                                                </td>
                                                <td class="p-0">{{$variant->cost_price}}</td>
                                                <td class="p-0">{{$variant->retail_price}}</td>
                                                <td class="p-0">{{$variant->discounted_price}}</td>
                                                <td class="p-0">{{$variant->barcode}}</td>
                                                <td class="p-0">{{$variant->sku}}</td>
                                                <td class="p-0">
                                                    <div class="table-action">
                                                        <a href="javascript:void(0);"
                                                           class="edit-order mr-3 edit-variant"
                                                           {{--                                                           data-toggle="modal"--}}
                                                           {{--                                                           data-target="#editVariant"--}}
                                                           data-variant_id="{{$variant->id}}"
                                                           data-title="{{$variant->title}}"
                                                           data-cost_price="{{$variant->cost_price}}"
                                                           data-retail_price="{{$variant->retail_price}}"
                                                           data-discoutned_price="{{$variant->discounted_price}}"
                                                           data-barcode="{{$variant->barcode}}"
                                                           data-sku="{{$variant->sku}}"
                                                           @if(optional($variant->images)->url)
                                                           data-image="{{optional($variant->images)->url}}"
                                                           @else
                                                           data-image="{{asset('business_assets/images/customer-placeholder.png')}}"
                                                           @endif
                                                        >
                                                            <img alt=""
                                                                 src="{{asset('business_assets/images/edit1.png')}}">
                                                        </a>
                                                        <a href="javascript:void(0);" class="print-order"
                                                           data-toggle="modal"
                                                           data-id="{{$variant->id}}"
                                                           data-url="{{route('delete-product-variant')}}"
                                                           data-modal="modal"
                                                           data-method="delete"
                                                           data-target="#confirmModal"
                                                           data-title="Delete this variant"
                                                        >
                                                            <img alt=""
                                                                 src="{{asset('business_assets/images/delete.png')}}" />
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3 mb-3">
                @endif
                <div id="products">
                    @if($product->variants->count() > 0)
                    <product-extra-update
                            get_addon_url="{{api_url('get_addon_url')}}"
                            :business_type="{{Auth::user()->business->business_type_id}}"
                            all-addons="{{json_encode(\App\Helpers\CommonHelper::addons())}}"
                            all-variants="{{json_encode(\App\Helpers\CommonHelper::variants())}}"
                            old-session="{{json_encode(old())}}"
                            product-existing-variant="{{json_encode($product->variants)}}"
                            product-existing-addons="{{json_encode(\App\Helpers\CommonHelper::getAddons($product->addons()->pluck('addon_id')))}}"
                            get_variant_options="{{api_url('get_variant_options')}}"
                            validation-errors="{{json_encode($errors->toArray())}}"
                            is_addon_or_variant="{{$product->has_addons_or_variants}}"
                            variant-list="{{json_encode($variantList)}}"
                            :product-has-variants="<?php echo $product->variants->count() > 0 ? 'true' : 'false'; ?>"
                    ></product-extra-update>
                    @else
                        <product-extra
                                all-addons="{{json_encode(\App\Helpers\CommonHelper::addons())}}"
                                all-variants="{{json_encode(\App\Helpers\CommonHelper::variants())}}"
                                old-session="{{json_encode(old())}}"
                                :business_type="{{Auth::user()->business->business_type_id}}"
                                get_addon_url="{{api_url('get_addon_url')}}"
                                get_variant_options="{{api_url('get_variant_options')}}"
                                validation-errors="{{json_encode($errors->toArray())}}"
                        ></product-extra>
                    @endif
                </div>
            </div>
        </div>
        {{--            <div class="col-lg-6">--}}

        {{--            </div>--}}
    </div>
    <div class="text-right">
        <button class="btn-size btn-rounded btn-primary">Update</button>
    </div>
    </div>
@endsection
@section('footer')
    <div class="selected-item-panel">
        <div class="selected-item">
            <div class="row align-items-center">
                <div class="col-md-3 col-sm-12">
                    <div class="item-show">
                        <span><img src="{{asset('business_assets/images/close-wgite.png')}}" alt="image"></span>
                        <p>2 Items Selected</p>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="item-btn">
                        <a href="javascript:void(0)"><img src="{{asset('business_assets/images/writing-white.png')}}"
                                                          alt="image"> Note</a>
                        <a href="javascript:void(0)">Multi Fulfill</a>
                        <a href="javascript:void(0)">Capture Payment</a>
                        <a href="javascript:void(0)"><img src="{{asset('business_assets/images/printer-white.png')}}"
                                                          alt="image"> Print
                            Options</a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('extras')
<div id="product-images" class="d-none">
    <div class="add-pro-thumbs mb-4">
        <div class="product-big">
        <span class="bg-gray">
            <img id="main_preview"
                 src="@if($product->main_image) {{$product->main_image}} @else {{asset('images/upload-big.png')}} @endif"
                 alt="">
        </span>
            @if($product->main_image)
            <span class="delete-product"
                  data-toggle="modal"
                  data-id="{{optional($product->main_image_obj)->id}}"
                  data-url="{{route('product-image-delete')}}"
                  data-modal="modal"
                  data-method="delete"
                  data-target="#confirmModal"
                  data-type="image"
                  data-title="Delete this image"
            >
                <i class="fas fa-trash-alt"></i>
            </span>
            @endif
            <span class="clicker-product" data-preview="#main_preview"
                  data-url="{{route('product-image-upload')}}"
                  data-form-data='@json(['product_id' => $product->id])'
                  data-name="images[main]"
                  data-toggle="fileupload">
                    <img alt="" src="{{asset('business_assets/images/plus-round.png')}}">
            </span>
        </div>
        <div class="product-small">
            @foreach($product->other_images as $other_image)
                <div class="thumb-list">
                    <img src="{!! $other_image->url !!}" id="preview{{$loop->iteration}}">
                    <span class="delete-product"
                          data-toggle="modal"
                          data-id="{{$other_image->id}}"
                          data-url="{{route('product-image-delete')}}"
                          data-modal="modal"
                          data-method="delete"
                          data-target="#confirmModal"
                          data-type="image"
                          data-title="Delete this image">
                        <i class="fas fa-trash-alt"></i>
                    </span>
                    <span class="clicker-product" data-preview="#preview{{$loop->iteration}}"
                          data-url="{{route('product-image-upload')}}"
                          data-form-data='@json(['product_id' => $product->id])'
                          data-name="images[{{$loop->iteration}}]"
                          data-toggle="fileupload"
                    >
                    <img alt="" src="{{asset('business_assets/images/plus-round.png')}}">
                </span>
                </div>
            @endforeach
            <?php $total = 3 - count($product->other_images); ?>
            @for($i=0; $i < $total; $i++)
                <div class="thumb-list">
                    <img src="{!! asset('images/upload-big.png') !!}"
                         id="preview{{$i+1+count($product->other_images)}}">
                    <span class="clicker-product"
                          data-preview="#preview{{$i+1+count($product->other_images)}}"
                          data-url="{{route('product-image-upload')}}"
                          data-form-data='@json(['product_id' => $product->id])'
                          data-name="images[{{$i+1+count($product->other_images)}}]"
                          data-toggle="fileupload"
                    >
                    <img alt="" src="{{asset('business_assets/images/plus-round.png')}}">
                </span>
                </div>
            @endfor
        </div>
    </div>
</div>
    <div class="modal fade customer-modal" id="editVariant" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{route('update-product-variant')}}" id="variant-form" method="post">
                        {!! csrf_field() !!}
                        <h3 class="font-weight-700 dark-one mb-2">Edit Variant Option</h3>
                        <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                            <div class="form-group">
                                {{--<span class="add-brand">
                                    <img class="variant-image" alt="" />
                                </span>--}}
                            </div>
                            <input type="hidden" id="edit_variant_id" name="variant[variant_id]"
                                   value="{{old('variant[variant_id]')}}">
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Cost Price</label>
                                {!! Form::number('variant[cost_price]',null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('variant.cost_price') ? 'border-danger' :''), 'id' => 'edit_cost_price']) !!}
                                @error('variant.barcode')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Retail Price</label>
                                {!! Form::number('variant[retail_price]',null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('variant.retail_price') ? 'border-danger' :''), 'id' => 'edit_retail_price']) !!}
                                @error('variant.retail_price')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Discounted Price</label>
                                {!! Form::number('variant[discounted_price]',null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('variant.discounted_price') ? 'border-danger' :''), 'id' => 'edit_discounted_price']) !!}
                                @error('variant.discounted_price')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Barcode</label>
                                {!! Form::text('variant[barcode]',null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('variant.barcode') ? 'border-danger' :''), 'id' => 'edit_barcode']) !!}
                                @error('variant.barcode')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">SKU</label>
                                {!! Form::text('variant[sku]',null, ['class' => 'form-control sm-radius-control white-border-control '.($errors->has('variant.sku') ? 'border-danger' :''), 'id' => 'edit_sku']) !!}
                                @error('variant.sku')
                                <div class="danger-bg input-info"><p>{{$message}}</p></div>
                                @enderror
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1 mb-1"
                           data-dismiss="modal" id="close-variant-modal">
                            Cancel
                        </a>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="variant_id" id="variant_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <input type="hidden" name="image_id" id="image_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title Product</span>?
                        </h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update this Product?</span>
                        </h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span
                                    data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1"
                           data-dismiss="modal">Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @if($product->variants->count() > 0)
        <script src="{{asset_timestamp('js/product-update.js')}}"></script>
    @else
        <script src="{{asset_timestamp('js/product.js')}}"></script>
    @endif
    <script src="{{asset_timestamp('js/image.js')}}"></script>
@endsection
@section('custom_script')
    <script>
        @if($errors->any() && session()->has('variant-validation'))
        $('#editVariant').modal();
        @endif
    </script>
    <script>
      $(function() {
        $(document).ready(function() {
          let $width = $(window).width();
          let $height = $(window).height();
          if ($width > 974) {
            $('#desktop-images').html($('#product-images').html())
            $('#mobile-images').html('')
          } else {
            $('#desktop-images').html('')
            $('#mobile-images').html($('#product-images').html())
          }
        });
        $(window).on('resize', function() {
          let $width = $(window).width();
          let $height = $(window).height();
          if ($width > 974) {
            $('#desktop-images').html($('#product-images').html())
            $('#mobile-images').html('')
          } else {
            $('#desktop-images').html('')
            $('#mobile-images').html($('#product-images').html())
          }
        });
      });
    </script>

    <script>
      function calculate ($parent = '#desktop-view') {
        let $costPrice = $($parent).find('.cost-price');
        let $retailPrice = $($parent).find('.retail-price');
        let $discountedPrice = $($parent).find('.discounted-price');
        let $margin = $($parent).find(+'.product_margin');
        let $profit = $($parent).find('.product_profit');

        let $retailPriceVal = $retailPrice.val();
        let $discountedPriceVal = $discountedPrice.val();
        let $costPriceVal = $costPrice.val();
        let $marginValue = 0;
        let $profitValue = 0;

        if (parseFloat($discountedPriceVal) > 0) {
          $profitValue = (parseFloat($discountedPriceVal) - parseFloat($costPriceVal));
          $marginValue = ($profitValue / $costPriceVal) * 100;
        } else {
          $profitValue = (parseFloat($retailPriceVal) - parseFloat($costPriceVal));
          $marginValue = ($profitValue / $costPriceVal) * 100;
        }
        $margin.text(formatValue($marginValue) + ' %');
        $profit.text(formatValue($profitValue) + ' AED');
      }

      $('.edit-variant').on('click', function() {

        let $modal = $('#editVariant');
        let $btnData = $(this).data();

        $modal.find('#edit_variant_id').val($btnData.variant_id);
        $modal.find('#edit_cost_price').val($btnData.cost_price);
        $modal.find('#edit_retail_price').val($btnData.retail_price);
        $modal.find('#edit_discounted_price').val($btnData.discounted_price);
        $modal.find('#edit_barcode').val($btnData.barcode);
        $modal.find('#edit_sku').val($btnData.sku);
        $modal.find('.variant-image').attr('src', $btnData.image);
        $modal.modal('show');
      });

      $('#close-variant-modal').on('click', function() {
        $('.white-border-control').removeClass('border-danger').siblings('.input-info').remove();
      });

      let ids = [];
      $(document).on('click','[data-modal="modal"]', function() {
        if ($(this).data('id') === 'bulk') {
          $.each($('.list-check:checked'), function() {
            ids.push($(this).val());
          });
          $('#variant_id').val(ids);
        }
        if($(this).data('type') === 'image'){
          $('#variant_id').val('');
          $('#image_id').val($(this).data('id'));
        }
        else {
          $('#variant_id').val($(this).data('id'));
          $('#image_id').val('');
        }
        $('#status_id').val($(this).data('status'));
        $('[data-modal-title="title"]').text($(this).data('title'));
        $('#confirmForm').attr('action', $(this).data('url'));
        $('#method').val($(this).data('method'));
        $;
      });

      $(function() {
        $(document).on('change', '#product-title', function() {
          let $val = $(this).val();

          $('#slug').val($val.replaceAll(/[^a-zA-Z0-9]/g, '-').toLowerCase())
        })
      })
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! \Proengsoft\JsValidation\Facades\JsValidatorFacade::formRequest('App\Http\Requests\ProductRequest', '#edit-product-form') !!}

@endsection
