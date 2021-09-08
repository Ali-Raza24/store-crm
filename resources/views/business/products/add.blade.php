<style>
    #productExtra #variants > table, td {
        border: 0 !important;
    }

    #productExtra #variants > tr {
        border-bottom: 1px solid #CDDEEB !important;
    }
</style>
<div class="add-customer-panel scroll-bar-thin all-product">
    <div class="add-customer-heading">
        <h3 class="dark-one font-weight-700">Add Product</h3>
        <span class="all-product-btn"><img src="{{asset('business_assets/images/close-black.png')}}" alt="image"></span>
    </div>
    {!! Form::open(['route' => 'product-store', 'files' => true, 'class' => 'right-side-from mt-5', 'id' => 'add-product-form', 'role' => 'form']) !!}
    <div class="d-flex justify-start">
        <span style="min-width: 225px; max-width: 225px">
            <strong>Main Image (360px X 400px)</strong>
        </span>
        <span class="mobile-hide">
            <strong>Alternative Images (360px X 400px)</strong>
        </span>
    </div>
    <div class="image-upload" id="image">
        <span class="main-image">
            <image-upload name="images[main]" placeholder-width="false" image_placeholder="{{asset('business_assets/images/upload-img1.png')}}"></image-upload>
        </span>
        <span class="other-image mobile-hide">
            <image-upload name="images[1]" placeholder-width="false" image_placeholder="{{asset('business_assets/images/upload-img2.png')}}"></image-upload>
        </span>
        <span class="other-image mobile-hide">
            <image-upload name="images[2]" placeholder-width="false" image_placeholder="{{asset('business_assets/images/upload-img2.png')}}"></image-upload>
        </span>
        <span class="other-image mobile-hide">
            <image-upload name="images[3]" placeholder-width="false" image_placeholder="{{asset('business_assets/images/upload-img2.png')}}"></image-upload>
        </span>
{{--        <a href="javascript:void(0)" class="btn-underline primary-text add-more-images">Add more images</a>--}}
    </div>
    <div class="d-flex justify-content-between" id="image-errors">
        <span style="min-width: 225px" id="images-main">
            @error('images.main')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </span>
        <span class="mobile-hide" id="images-1">
            @error('images.1')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </span>
        <span class="mobile-hide" id="images-2">
            @error('images.2')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </span>
        <span class="mobile-hide" id="images-3">
            @error('images.3')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </span>
    </div>
    <script src="{{asset('js/image.js')}}"></script>
        <div class="row">
            <div class="col-md-12">
                <h4 class="dark-one font-weight-700 mt-4 mb-4">Product Information</h4>
                <div class="form-group mt-5 discount-code">
                    <label>Product Title</label>
                    {!! Form::text('title',null, ['class' => 'order-edit-control form-control '.($errors->has('title') ? 'border-danger' :''), 'id' => 'product-title']) !!}
                    @error('title')
                    <div class="danger-bg input-info"><p>{!! $message !!}</p></div>
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

                <div class="form-group mt-5 discount-code">
                    <label>Description</label>
                    {!! Form::textarea('description', null, ['class' => 'order-edit-control form-control '.($errors->has('description') ? 'border-danger' :'')]) !!}
                    @error('description')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label class="font-weight-600 mb-2 dark-one">Brand </label>
                        <div>
                            @if(plan_has_permission(['brand-create']))
                                <a href="javascript:void(0)" class="btn-underline primary-text" data-toggle="modal" data-target="#addNewBrand">
                                    + Add New
                                </a>
                            @endif
                        </div>
                    </div>
                    {!! Form::select('brand_id', [], null, ['class' => 'order-edit-control form-control '.($errors->has('brand_id') ? 'border-danger' :''), 'id' => 'brand_id']) !!}
                    @error('brand_id')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label class="font-weight-600 mb-2 dark-one">Category </label>
                        <div>
                            @if(plan_has_permission(['category-create']))
                                <a href="javascript:void(0)" class="btn-underline primary-text" data-toggle="modal"
                                   data-target="#addNewCategory">
                                    + Add New
                                </a>
                            @endif
                        </div>
                    </div>
                    {!! Form::select('categories[]',
                            [],
                            null,
                            ['class' => 'order-edit-control form-control '.($errors->has('categories') ? 'border-danger' :''), 'id' => 'categories',
                             'multiple' => true]) !!}
                    @error('categories')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label class="font-weight-600 mb-2 dark-one">Cost Price (AED) </label>
                    {!! Form::text('cost_price',null, ['class' => 'order-edit-control form-control '.($errors->has('cost_price') ? 'border-danger' :''), 'placeholder' => 'AED 0', 'id' => 'cost-price', 'onkeyup' => 'calculate()']) !!}
                    @error('cost_price')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label class="font-weight-600 mb-2 dark-one"> Retail Price (AED)</label>
                    {!! Form::text('retail_price',null, ['class' => 'order-edit-control form-control '.($errors->has('retail_price') ? 'border-danger' :''), 'placeholder' => 'AED 0', 'id' => 'retail-price', 'onkeyup' => 'calculate()']) !!}
                    @error('retail_price')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label class="font-weight-600 mb-2 dark-one">Discounted Price (AED)</label>
                    {!! Form::text('discounted_price',null, ['class' => 'order-edit-control form-control '.($errors->has('discounted_price') ? 'border-danger' :''), 'placeholder' => 'AED 0', 'id' => 'discounted-price', 'onkeyup' => 'calculate()']) !!}
                    @error('discounted_price')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="d-flex align-items-center h-100">
                    <div class="form-group mr-5">
                        <label class="font-weight-600 mb-0 dark-one"> Margin: </label>
                        <input type="hidden" class="">
                        <p class="dark-four m-0" id="product_margin">0%</p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-600 mb-0 dark-one"> Profit: </label>
                        <input type="hidden" class="">
                        <p class="dark-four m-0" id="product_profit">0.0 AED</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label class="font-weight-600 mb-2 dark-one">Weight</label>
                    {!! Form::text('weight',null, ['class' => 'order-edit-control form-control '.($errors->has('weight') ? 'border-danger' :'')]) !!}
                    @error('weight')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label class="font-weight-600 mb-2 dark-one">Volume</label>
                    {!! Form::text('volume',null, ['class' => 'order-edit-control form-control '.($errors->has('volume') ? 'border-danger' :'')]) !!}
                    @error('volume')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="font-weight-600 mb-2 dark-one">Product Availability Stores </label>
                    {!! Form::select('stores[]',
                            \App\Helpers\CommonHelper::stores()->pluck('name','id'),
                            (session()->get('store-data'))->id,
                            ['class' => 'js-select2 order-edit-control form-control '.($errors->has('stores.0') ? 'border-danger' :''),
                             'multiple' => true]) !!}
                    @error('stores.0')
                    <div class="danger-bg input-info"><p>{{$message}}</p></div>
                    @enderror
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
    <div id="productExtra">
        <div id="products">
            <product-extra
                    all-addons="{{json_encode(\App\Helpers\CommonHelper::addons())}}"
                    all-variants="{{json_encode(\App\Helpers\CommonHelper::variants())}}"
                    old-session="{{json_encode(old())}}"
                    :business_type="{{Auth::user()->business->business_type_id}}"
                    get_addon_url="{{api_url('get_addon_url')}}"
                    get_variant_options="{{api_url('get_variant_options')}}"
                    validation-errors="{{json_encode($errors->toArray())}}"
            ></product-extra>
        </div>
    </div>
        <div class="form-group">
            <button class="btn-primary btn-rounded btn-size">Save</button>
            <a href="javascript:void(0)" class="btn-gray btn-rounded btn-size all-product-btn">Cancel</a>
        </div>
    {!! Form::close() !!}
</div>
