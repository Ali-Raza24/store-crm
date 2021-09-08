<div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
    <div class="col-md-12 table-filter-wrap">
        <div class="col-filter">
            <nav class="tabs-head mobile-hide" id="allOrders">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link @if(request()->routeIs('products-list')) active @endif"
                       id="AllProducts-tab" href="{{route('products-list')}}"
                       role="tab" aria-controls="AllProducts" aria-selected="true">All Products</a>
                    <a class="nav-item nav-link @if(request()->routeIs('products-list-discounted')) active @endif"
                       id="Discounted-Products-tab" href="{{route('products-list-discounted')}}"
                       role="tab" aria-controls="Discounted-Products"
                       aria-selected="false">Discounted Products</a>
                    <a class="nav-item nav-link @if(request()->routeIs('products-list-inactive')) active @endif" id="Inactive-Products-tab"
                       href="{{route('products-list-inactive')}}" role="tab" aria-controls="Inactive-Products" aria-selected="false">Inactive
                        Products</a>
                </div>
            </nav>
            <div class="dropdown tabs-dropdown desktop-hide">
                <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    All Orders
                </button>
                <div class="dropdown-menu" aria-labelledby="dropTab">
                    <a class="nav-item nav-link active" href="javascript:void(0)">All Orders</a>
                    <a class="nav-item nav-link" href="javascript:void(0)">Unfulfilled</a>
                    <a class="nav-item nav-link" href="javascript:void(0)">Unpaid</a>
                    <a class="nav-item nav-link" href="javascript:void(0)">Out of Delivery</a>
                </div>
            </div>
        </div>
        <div class="col-filter">
            <div class="table-misc d-flex justify-content-between">
                <ul class="table-filter">
                    @if(plan_has_permission(['product-import']))
                    <li data-toggle="modal" data-target="#impCsv">
                        <img alt="" src="{{asset('business_assets/images/download.png')}}">
                        Import
                    </li>
                    @endif
                    @if(plan_has_permission(['product-export']))
                    <li><a target="_blank" href="{{route('product-export')}}"><img alt="" src="{{asset('business_assets/images/upload.png')}}"> Export</a></li>
                        @endif
                    <li>
                        <form>
                            <div class="dropdown order-list-drop">
                            <button class="dropdown-toggle" type="button" id="dropTFilter" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <img alt="" src="{{asset('business_assets/images/filter.png')}}"> Filters
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTFilter">
                                <div class="dropdown-box">
                                    <div class="form-group">
                                        <label class="dark-one font-weight-600">Categories</label>
                                        {!! Form::select('categories[]', \App\Helpers\CommonHelper::categories(), request()->get('categories'), ['class' =>'js-select2 order-edit-control form-control', 'multiple']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label class="dark-one font-weight-600">Stores</label>
                                        {!! Form::select('stores[]', \App\Helpers\CommonHelper::stores(true), request()->get('stores'), ['class' =>'js-select2 order-edit-control form-control', 'multiple']) !!}
                                    </div>
                                </div>

                                <div class="drop-footer grey-one d-flex justify-content-between">
                                    <button class="apply-filter dark-one"> Apply
                                    </button>
                                    <a href="{{url()->current()}}" class="filter dark-two">Clear Filters</a>
                                    <a data-toggle="dropdown" class="cancel-filter dark-two">
                                        Cancel</a>
                                </div>
                            </div>
                        </div>
                        </form>
                    </li>
                        @if(plan_has_permission(['product-create']))
                    <li>
                        @if(!empty($planOption) && ($planOption->option == \App\Constants\AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS || $planOption->values >=  $productCount))
                            <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary all-product-btn mobile-hide"> Add Product</a>
                        @else
                            <a href="{{route('products-create')}}" class="btn-size btn-rounded btn-primary mobile-hide"> Add Product</a>
                        @endif
                    </li>
                            @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<hr class="m-0">
<h3 class="border-heading dark-one font-weight-700 mt-lg-5 mt-4 desktop-hide"> All Products
    @if(plan_has_permission(['product-create']))
    @if(!empty($planOption) && ($planOption->option == \App\Constants\AppConstants::PLAN_OPTION_UNLIMITED_PRODUCTS || $planOption->values >=  $productCount))
        <a href="javascript:void(0)" class="btn-primary btn-rounded btn-order desktop-hide all-product-btn"> Add Product</a>
    @else
        <a href="{{route('products-create')}}" class="btn-primary btn-rounded btn-order desktop-hide"> Add Product</a>
    @endif
        @endif
</h3>
