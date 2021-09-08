@extends('layouts.business.app')
@section('title', "")
@section('content')
    <div class="row counter-wrapp scroller-h">
        <x-counter-box border_color="primary" text_color="primary" title="All Orders" total="546579" />
        <x-counter-box border_color="warning" text_color="warning" title="Pending Orders" total="2854" />
        <x-counter-box border_color="danger" text_color="danger" title="Unpaid" total="2851" />
        <x-counter-box border_color="success" text_color="success" title="Out Of Delivery" total="34654" />
    </div>
    <div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
        <div class="col-md-12 table-filter-wrap">
            <div class="col-filter">
                <nav class="tabs-head mobile-hide" id="allOrders">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link @if(request()->routeIs('orders-list'))  active @endif" id="AllOrders-tab"
                           href="{{route('orders-list')}}" role="tab" aria-controls="AllOrders" aria-selected="true">All
                            Orders</a>
                        <a class="nav-item nav-link @if(request()->routeIs('unfulfillment-orders-list'))  active @endif" id="Unfulfilled-tab"
                           href="{{route('unfulfillment-orders-list')}}" role="tab" aria-controls="Unfulfilled"
                           aria-selected="false">Unfulfilled</a>
                        <a class="nav-item nav-link @if(request()->routeIs('unpaid-orders-list'))  active @endif" id="Unpaid-tab" href="{{route('unpaid-orders-list')}}"
                           role="tab" aria-controls="Unpaid" aria-selected="false">Unpaid</a>
                        <a class="nav-item nav-link @if(request()->routeIs('outof-delivered-orders-list'))  active @endif" id="OfDelivery-tab"
                           href=" {{route('outof-delivered-orders-list')}}" role="tab" aria-controls="OfDelivery"
                           aria-selected="false">Out of Delivery</a>
                    </div>
                </nav>
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        All Orders
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link @if(request()->routeIs('orders-list'))  active @endif" href="{{ route('orders-list') }}">All Orders</a>
                        <a class="nav-item nav-link @if(request()->routeIs('unfulfillment-orders-list'))  active @endif" href="{{route('unfulfillment-orders-list')}}">Unfulfilled</a>
                        <a class="nav-item nav-link @if(request()->routeIs('unpaid-orders-list'))  active @endif" href="{{ route('unpaid-orders-list') }}">Unpaid</a>
                        <a class="nav-item nav-link @if(request()->routeIs('outof-delivered-orders-list'))  active @endif" href="{{ route('outof-delivered-orders-list') }}">Out of Delivery</a>
                    </div>
                </div>
            </div>
            <div class="col-filter">
                <div class="table-misc d-flex justify-content-between">
                    <div class="date-picker">
                        <div class="form-group form-icon">
                            <input type="date" class="form-control">
                            <span>
                                <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                            </span>
                        </div>
                        <div class="form-group text-center">to</div>
                        <div class="form-group form-icon">
                            <input type="date" class="form-control">
                            <span>
                                <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                            </span>
                        </div>
                    </div>
                    <ul class="table-filter">
                        <li data-toggle="modal" data-target="#impCsv"><img alt="" src="{{asset('business_assets/images/download.png')}}"> Import</li>
                        <li><img alt="" src="{{asset('business_assets/images/upload.png')}}"> Export</li>
                        <li>
                            <div class="dropdown order-list-drop">
                                <button class="dropdown-toggle" type="button" id="dropTFilter"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img alt="" src="{{asset('business_assets/images/filter.png')}}"> Filters
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropTFilter">
                                    <div class="dropdown-box">
                                        <p class="dark-one font-weight-600">Payment Status</p>
                                        <a class="filter-opt btn-gray" href="javascript:void(0)">Paid</a>
                                        <a class="filter-opt btn-gray" href="javascript:void(0)">Payment
                                            Pending</a>
                                        <a class="filter-opt btn-gray"
                                           href="javascript:void(0)">Refunded</a>
                                        <a class="filter-opt btn-gray"
                                           href="javascript:void(0)">Cancelled</a>
                                    </div>
                                    <hr class="m-0">
                                    <div class="dropdown-box">
                                        <p class="dark-one font-weight-600">Fulfilled Status</p>
                                        <a class="filter-opt btn-gray"
                                           href="javascript:void(0)">Unfulfilled</a>
                                        <a class="filter-opt btn-gray"
                                           href="javascript:void(0)">Processing</a>
                                        <a class="filter-opt btn-gray"
                                           href="javascript:void(0)">Cancelled</a>
                                        <a class="filter-opt btn-gray" href="javascript:void(0)">Out of
                                            Delivery</a>
                                    </div>

                                    <div class="drop-footer grey-one">
                                        <a href="javascript:void(0)" class="cancel-filter dark-two">
                                            Cancel</a>
                                        <a href="javascript:void(0)" class="apply-filter dark-one"> Apply
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <hr class="m-0">
    @include('flash::message')
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade @if(request()->routeIs('outof-delivered-orders-list')) show active @endif" id="OfDelivery" role="tabpanel" aria-labelledby="OfDelivery">
            @include('business.orders.partials.all_orders')
        </div>

    </div>
@endsection
@section('footer')
    <div class="selected-item-panel">
        <div class="selected-item">
            <ul class="selected-list">
                <li>
                    <div class="item-show">
                        <span><img src="{{asset('business_assets/images/close-wgite.png')}}" alt="image"></span>
                        <p class="mobile-hide">2 Items Selected</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option mobile-hide">
                        <img src="{{asset('business_assets/images/writing-white.png')}}" alt="image">
                        <span>Note</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn">
                        <span>Multi Fulfill</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn">
                        <span>Capture Payment</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn print-option">
                        <img src="{{asset('business_assets/images/printer-white.png')}}" alt="image">
                        <span>Print Options</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('extras')
    <!-- update order status -->
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="order_id" id="order_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> Order?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update</span> this Order?</h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Update</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                            Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Import Customers Form  -->
    <div class="modal fade customer-modal" id="impCsv" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">Import Customers form CSV file</h3>
                    <div class="form-group mt-4 mb-4 w-75 ml-auto mr-auto">
                        <div class="form-icon">
                            <input type="url" placeholder="C/:"
                                   class="form-control sm-radius-control white-border-control">
                            <span>
                                <img alt="" src="images/folder.png">
                            </span>
                        </div>
                    </div>
                    <h4 class="dark-two mb-3">
                        Download a sample file CSV file <span class="dark-one font-weight-600">Click Here</span>
                    </h4>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1"> Upload </a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                        Cancel </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
    <script>
        $.ajaxSetup({
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        })

        // order payment status change
        function orderPaymentStatusChange(order_id, status_id) {
            $('.dropdown-toggle').dropdown('hide');
            if (order_id != '' && status_id != '') {
                $.ajax({
                    url: '{{ route("change-status-orders") }}',
                    type: 'GET',
                    dataType: 'json',
                    data: { order_id: order_id, status_id: status_id },
                    success: function (data) {
                        $('#dropdown-text-'+order_id).text(data)
                    }
                })
            } else {alert('Error!, Order id not found.')}
        }
        // order  status change
        function orderFulfillmentStatusChange(order_id, status_id) {
            $('.dropdown-toggle').dropdown('hide');
            if (order_id != '' && status_id != '') {
                $.ajax({
                    url: '{{ route("change-fulfillment-status-orders") }}',
                    type: 'GET',
                    dataType: 'json',
                    data: { order_id: order_id, status_id: status_id },
                    success: function (data) {
                        $('#dropdown-textorder-'+order_id).text(data)
                    }
                })
            } else {alert('Error!, Order id not found.')}
        }

    </script>
@endsection
