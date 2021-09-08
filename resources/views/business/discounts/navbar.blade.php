<div class="row counter-wrapp scroller-h">
    <x-counter-box column="4" border_color="primary" text_color="primary" title="Total Discounts"
                   total="{{$discounts_total}}"
                   class="mt-lg-4 mt-3" />
    <x-counter-box column="4" border_color="green" text_color="green" title="Active Discount"
                   total="{{$discounts_total_active}}"
                   class="mt-lg-4 mt-3" />
    <x-counter-box column="4" border_color="lightblue" text_color="lightblue" title="Value Used"
                   total="{{$discounts_used_total}}"
                   class="mt-lg-4 mt-3" />
</div>
<div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
    <div class="col-12"> @include('flash::message')</div>
    <div class="col-md-12 table-filter-wrap">
        <div class="col-filter">
            <nav class="tabs-head mobile-hide" id="allOrders">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link @if(request()->routeIs('discount-list'))active @endif"
                       id="AllDiscount-tab" href="{{route('discount-list', request()->getQueryString())}}"
                       role="tab" aria-controls="AllDiscount" aria-selected="true">All Discounts</a>
                    <a class="nav-item nav-link @if(request()->routeIs('discount-list-expire'))active @endif"
                       id="Expired-tab" href="{{route('discount-list-expire', request()->getQueryString())}}" role="tab"
                       aria-controls="Expired" aria-selected="false">Expired</a>
                    <a class="nav-item nav-link @if(request()->routeIs('discount-list-active'))active @endif"
                       id="OfActive-tab" href="{{route('discount-list-active', request()->getQueryString())}}" role="tab"
                       aria-controls="OfActive" aria-selected="false">Active</a>
                </div>
            </nav>
            <div class="dropdown tabs-dropdown desktop-hide">
                <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    All Discount
                </button>
                <div class="dropdown-menu" aria-labelledby="dropTab">
                    <a class="nav-item nav-link active" href="{{route('discount-list', request()->getQueryString())}}">All Discount</a>
                    <a class="nav-item nav-link" href="{{route('discount-list-expire', request()->getQueryString())}}">Expired</a>
                    <a class="nav-item nav-link" href="{{route('discount-list-active', request()->getQueryString())}}">Active</a>
                </div>
            </div>
        </div>
        <div class="col-filter">
            <div class="table-misc d-flex justify-content-between">
                <ul class="table-filter">
{{--                    <li><img alt="" src="{{asset('business_assets/images/upload.png')}}"> Export</li>--}}
                    <li>
                        <form>
                            <div class="dropdown order-list-drop">
                            <button class="dropdown-toggle" type="button" id="dropTFilter"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img alt="" src="{{asset('business_assets/images/filter.png')}}"> Filters
                            </button>
                            <div class="dropdown-menu dropdown-menu-right"
                                 aria-labelledby="dropTFilter">
                                <div class="dropdown-box">
                                    <p class="dark-one font-weight-600">Used</p>
                                    <div class="price-range-slider">
                                        <div id="slider-range"
                                             class="noUi-target noUi-ltr noUi-horizontal noUi-background">

                                        </div>
                                        <div class="slider-labels">
                                            <div class="caption">
                                                <span id="slider-range-value1">0</span>
                                            </div>
                                            <div class="caption">
                                                <span id="slider-range-value2">500</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="discount_min_used" value="">
                                        <input type="hidden" name="discount_max_used" value="">
                                    </div>
                                </div>
                                <div class="dropdown-box">
                                    <p class="dark-one font-weight-600">Discount Range</p>
                                    <div class="price-range-slider">
                                        <div id="slider-range-amount"
                                             class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                                        </div>
                                        <div class="slider-labels">
                                            <div class="caption">
                                                <span id="slider-amount-value1">AED1</span>
                                            </div>
                                            <div class="caption">
                                                <span id="slider-amount-value2">AED500</span>
                                            </div>
                                        </div>
                                        <form>
                                            <input type="hidden" name="discount_min_amount" value="">
                                            <input type="hidden" name="discount_max_amount" value="">
                                        </form>
                                    </div>
                                </div>
                                <hr class="mb-0">
                                <div class="dropdown-box mb-3">
                                    <p class="dark-one font-weight-600">Active Discounts</p>
                                    <div class="date-picker">
                                        <div class="form-group form-icon">
                                            <input name="from_date" type="date" class="form-control">
                                            <span>
                                                <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                                            </span>
                                        </div>
                                        <div class="form-group text-center">to</div>
                                        <div class="form-group form-icon">
                                            <input name="to_date" type="date" class="form-control">
                                            <span>
                                                <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                                            </span>
                                        </div>
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
                    @if(plan_has_permission(['discount-create']))
                    <li>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary add-discount-btn mobile-hide">Add Discount</a>
                    </li>
                        @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<hr class="m-0">
<h3 class="border-heading dark-one font-weight-700 mt-lg-5 mt-4 desktop-hide"> All Discounts
    @if(plan_has_permission(['discount-create']))
    <a class="btn-primary btn-rounded btn-order desktop-hide add-discount-btn" href="javascript:void(0)"> Add
        Discount </a>
        @endif
</h3>
