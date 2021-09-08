@extends('layouts.business.app')
@section('content')
    <div class="row counter-wrapp scroller-h">
        <x-counter-box border_color="primary" text_color="primary" title="Total Orders" total="{{$ordersCount}}" icon="order2.png"/>
        <x-counter-box border_color="green" text_color="green" title="Total Sales" total="{{$totalSales}}" icon="payment2.png"/>
        <x-counter-box border_color="pending" text_color="pending" title="Pending Orders" total="{!! $pendingOrdersCount !!}" icon="product2.png"/>
        <x-counter-box border_color="dark-pink" text_color="dark-pink" title="Total Customers" total="{!! $customersCount !!}" icon="user2.png"/>
    </div>
    <div class="row">
        <div class="col-12">
            @include('flash::message')
        </div>
    </div>
    <div class="row">
        @if(plan_permission('order'))
        <div class="col-xl-9 col-md-8">
            <h3 class="border-heading dark-one font-weight-700 mt-lg-5 mt-4">Recent Orders
                <a class="btn-primary btn-rounded btn-order pagescroll desktop-hide"
                   href="#{!! route('orders-list') !!}"> View All </a>
            </h3>
            <div class="sf-orders">
                <div class="table-responsive scroll-bar-thin">
                    <table class="table table-space">
                        <thead>
                        <tr>
                            <th scope="col">Orders No</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Total</th>
                            <th scope="col">Payment</th>
                            <th scope="col">Store Location</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($latestOrders as $order)
                        <tr>
                            <td>
                                <div class="table-order-no">
                                    @if(!empty($order->formatted_number))
                                        <strong class="dark-one"><a href="{{route('orders-detail', ['id' => $order->formatted_number])}}">#{!! $order->formatted_number !!}</a></strong>
                                    @else
                                        <strong class="dark-one"><a href="{{route('orders-detail', ['id' => $order->id])}}">#{!! $order->id !!}</a></strong>
                                    @endif
                                    <p class="mb-0">{!! \Carbon\Carbon::parse($order->created_at)->format('M d, Y') !!}</p>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 order-name">{!! optional($order->customer)->name !!}</p>
                            </td>
                            <td><p class="mb-0 order-total">AED {{$order->total}}</p></td>
                            <?php
                            $paymentStatuses = \App\Helpers\CommonHelper::paymentStatus();
                            ?>
                            @if(plan_has_permission(['order-payment']))
                                <td>
                                    <div class="dropdown table-payment">

                                        <button class="dropdown-toggle {{\App\Helpers\CommonHelper::paymentStatusColor($order->payment_status_id)}}"
                                                type="button" id="dropPay1"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                             <span id="dropdown-text-{{ $order->id }}">
                                    {{$paymentStatuses[$order->payment_status_id]}}
                             </span>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="dropPay1">
                                            @foreach($paymentStatuses as $key => $paymentStatus)
                                                @if($key != $order->payment_status_id)
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                       data-url="{{route('order-status', ['type' => 'payment'])}}"
                                                       data-status="{{$key}}"
                                                       data-type="put"
                                                       data-toggle="modal"
                                                       data-modal="modal"
                                                       data-target="#confirmModal"
                                                       data-title="{{$paymentStatus}}"
                                                       data-id="{{$order->id}}"
                                                    >{{$paymentStatus}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            @else
                                <td>
                                    <div class="table-payment">
                                        <button class="payment-text {{\App\Helpers\CommonHelper::paymentStatusColor($order->payment_status_id)}}"
                                                type="button">
                             <span id="dropdown-text-{{ $order->id }}">
                                    {{$paymentStatuses[$order->payment_status_id]}}
                             </span>
                                        </button>
                                    </div>
                                </td>
                            @endif
                            <td><p style="white-space: pre-wrap">{{optional($order->store)->name}}</p></td>
                            <td>
                                <div class="table-action">
                                    <a href="{!! route('orders-edit', ['id' => $order->id]) !!}" class="edit-order">
                                        <img alt="" src="{{asset('business_assets/images/edit.png')}}">
                                    </a>
                                    {{--<a href="javascript:void(0)" class="print-order">
                                        <img alt="" src="{{asset('business_assets/images/print.png')}}">
                                    </a>--}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        <div class="col-xl-3 col-md-4 order--sm-last">
            <div class="sf-activities">
                <h3 class="dark-one noborder-heading border-heading font-weight-700 mb-4">Recent Activities</h3>
                <div class="activity-panel card-repeat scroll-bar-thin">
                    @foreach($recentActivities as $activity)
                    <div class="media">
                        <span class="mr-2 activity-icon"></span>
                        <div class="media-body">
                            <p class="mb-0">{!! $activity->description !!} #{!! $activity->subject_id !!}</p>
                            <small class="dark-four">by <b>{!! optional($activity->user)->name !!}</b> - {!! \Carbon\Carbon::parse($activity->created_at)->format('d M, Y H:i a') !!}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-12  mb-5 mb-sm-4">
            <h4 class="border-heading dark-one font-weight-700 mt-4">Reports</h4>
            <div class="row chart-wrapp scroller-h">
                <div class="col-6">
                    <div class="card-repeat mt-4">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-4">
                                    <h4 class="dark-one"> Total Sales </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">AED {!! $totalSales !!}</h3>
                                </div>
                                {{--<div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)"> View Report </a>
                                    <h3 class="chart-percent primary-text">
                                        <span><img alt="" src="{{asset('business_assets/images/arrow-up-g.png')}}"> </span>
                                        124%
                                    </h3>
                                </div>--}}
                            </div>
                            <div class="chart">
                                {!! $salesChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-repeat mt-4">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-3">
                                    <h4 class="dark-one"> Customers </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">{!! $customersCount !!}</h3>
                                </div>
                                {{--<div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)"> View Report </a>
                                    <h3 class="chart-percent primary-text">
                                        <span><img alt="" src="{{asset('business_assets/images/arrow-up-g.png')}}"> </span>
                                        124%
                                    </h3>
                                </div>--}}
                            </div>
                            <div class="chart">
                                {!! $customersChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @include('layouts.jquery')
@endsection

@section('custom_script')
    {!! $salesChart->script() !!}
    {!! $customersChart->script() !!}

    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="order_id" id="order_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> Order?
                        </h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update</span>
                            this Order?</h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span
                                    data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1"
                           data-dismiss="modal">
                            Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
      let ids = [];
      $('[data-modal="modal"]').on('click', function() {
        if ($(this).data('id') === 'bulk') {
          $.each($('.list-check:checked'), function() {
            ids.push($(this).val());
          });
          $('#order_id').val(ids);
        } else {
          $('#order_id').val($(this).data('id'));
        }
        $('#status_id').val($(this).data('status'));
        $('[data-modal-title="title"]').text($(this).data('title'));
        $('#confirmForm').attr('action', $(this).data('url'));
        $('#method').val($(this).data('type'));
        $;
      });

    </script>
@endsection
