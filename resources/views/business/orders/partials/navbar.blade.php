<div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
    <div class="col-md-12 table-filter-wrap">
        <div class="col-filter">
            <nav class="tabs-head mobile-hide" id="allOrders">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link @if(request()->routeIs('orders-list')) active @endif" href="{{route('orders-list')}}">All Orders</a>
                    <a class="nav-item nav-link @if(request()->routeIs('orders-list-unpaid')) active @endif" href="{{route('orders-list-unpaid')}}">Pending Payments</a>
                    <a class="nav-item nav-link @if(request()->routeIs('orders-list-delivery-out')) active @endif" href=" {{route('orders-list-delivery-out')}}">Shipped</a>
                </div>
            </nav>
            <div class="dropdown tabs-dropdown desktop-hide">
                <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    All Orders
                </button>
                <div class="dropdown-menu" aria-labelledby="dropTab">
                    <a class="nav-item nav-link @if(request()->routeIs('orders-list')) active @endif" href="{{ route('orders-list') }}">All Orders</a>
                    <a class="nav-item nav-link @if(request()->routeIs('orders-list-unpaid')) active @endif" href="{{ route('orders-list-unpaid') }}">Pending Payments</a>
                    <a class="nav-item nav-link @if(request()->routeIs('orders-list-delivery-out')) active @endif" href="{{ route('orders-list-delivery-out') }}">Shipped</a>
                </div>
            </div>
        </div>
        <div class="col-filter">
            <div class="table-misc d-flex justify-content-between">
                <form id="date_filter">
                <div class="date-picker">
                    <div class="form-group form-icon">
                        <input name="from_date" type="date" class="form-control" id="from_date">
                        <span>
                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                        </span>
                    </div>
                    <div class="form-group text-center">to</div>
                    <div class="form-group form-icon">
                        <input name="to_date" type="date" class="form-control" id="to_date">
                        <span>
                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                        </span>
                    </div>
                </div>
                </form>
                <ul class="table-filter">
                    {{--<li data-toggle="modal" data-target="#impCsv"><img alt="" src="{{asset('business_assets/images/download.png')}}"> Import</li>--}}
                    @if(plan_has_permission(['order-export']))
                    <li><a target="_blank" href="{{route('order-export')}}"><img alt="" src="{{asset('business_assets/images/upload.png')}}"> Export</a></li>
                    @endif
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
                                    <p class="dark-one font-weight-600">Payment Status</p>
                                    @foreach(\App\Helpers\CommonHelper::paymentStatus() as $key => $payment)
                                        <label for="paymentStatus{{$key}}"
                                               class="filter-opt btn-gray cursor-pointer @if(!empty(request()->get('payment_status')) && in_array($key, request()->get('payment_status'))) selected @endif"
                                        >
                                            <input id="paymentStatus{{$key}}"
                                                   name="payment_status[]"
                                                   type="checkbox"
                                                   value="{{$key}}"
                                                   class="d-none order-filter"
                                                   @if(!empty(request()->get('payment_status')) && in_array($key, request()->get('payment_status'))) checked @endif
                                            />
                                            {{ $payment }}
                                        </label>
                                    @endforeach
                                </div>
                                <hr class="m-0">
                                <div class="dropdown-box">
                                    <p class="dark-one font-weight-600">Fulfilled Status</p>
                                    @foreach(\App\Helpers\CommonHelper::fulfilmentStatus() as $key => $fulfilment)
                                        <label for="fulfilmentStatus{{$key}}"
                                               class="filter-opt btn-gray cursor-pointer @if(!empty(request()->get('fulfilment_status')) && in_array($key, request()->get('fulfilment_status'))) selected @endif "
                                        >
                                            <input id="fulfilmentStatus{{$key}}"
                                                   name="fulfilment_status[]"
                                                   type="checkbox"
                                                   value="{{$key}}"
                                                   class="d-none order-filter"
                                                   @if(!empty(request()->get('fulfilment_status')) && in_array($key, request()->get('fulfilment_status'))) checked @endif
                                            />
                                            {{ $fulfilment }}
                                        </label>
                                    @endforeach
                                </div>

                                <div class="drop-footer grey-one d-flex justify-content-between">
                                    <button class="apply-filter dark-one"> Apply
                                    </button>
                                    <a href="{{url()->current()}}" class="clear-filter dark-two">
                                        Clear</a>
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="cancel-filter dark-two">
                                        Cancel</a>
                                </div>
                            </div>
                        </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
