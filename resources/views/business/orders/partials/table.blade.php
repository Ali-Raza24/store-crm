<div class="sf-order">
    <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check">
            <thead>
            <tr>
                @if(plan_has_permission(['order-bulk-status']))
                    <th scope="col" class="custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkAll" />
                        <label class="custom-control-label" for="checkAll"></label>
                    </th>
                @endif
                <th scope="col">Orders No</th>
                <th scope="col">Customer</th>
                <th scope="col">Store Location <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                <th scope="col">Payment <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                @if(plan_has_permission(['order-status']))
                    <th scope="col">Fulfilled <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                @endif
                <th scope="col">Total</th>
                @if(Auth::user()->id != 1)
                    <th scope="col">Actions</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @php
                $paymentStatuses = \App\Helpers\CommonHelper::paymentStatus();
                $fulfilmentStatuses = \App\Helpers\CommonHelper::fulfilmentStatus();
                /**
                * @var $order \App\Models\Order
                **/
            @endphp
            @foreach($orders as $key => $order)
                <tr>
                    @if(plan_has_permission(['order-bulk-status']))
                        <td class="custom-checkbox show-selected">
                            <input type="checkbox" value="{{$order->id}}" name="bulk_ids[]"
                                   class="custom-control-input list-check" id="customCheck{{$loop->iteration+2}}" />
                            <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>
                        </td>
                    @endif
                    <td>
                        <div class="table-order-no">
                            <strong class="dark-one">
                                @if(Auth::user()->id != 1)
                                    @if(plan_has_permission(['order-view']))
                                        @if(!empty($order->formatted_number))
                                            <a href="{{route('orders-detail', ['id' => $order->formatted_number])}}">{{$order->formatted_number ?? '' }}</a>
                                        @else
                                            <a href="{{route('orders-detail', ['id' => $order->id])}}">{{$order->id ?? '' }}</a>
                                        @endif
                                    @else
                                        @if(!empty($order->formatted_number))
                                            <a href="#">{{$order->formatted_number ?? '' }}</a>
                                        @else
                                            <a href="#">{{$order->id ?? '' }}</a>
                                        @endif

                                    @endif
                                @else
                                    <a href="{{route('admin-orders-detail', ['id' => $order->id])}}">{{$order->formatted_number ?? '' }}</a>
                                @endif
                            </strong>
                            <p class="mb-0">{{$order->date_created }}</p>
                        </div>
                    </td>
                    <td width="200px">
                        <p class="mb-0 order-name">{{optional($order->customer)->name }}</p>
                    </td>
                    <td>
                        <p style="white-space: pre-wrap">{{optional($order->store)->name}}</p>
                    </td>
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
                    @if(plan_has_permission(['order-status']))
                        <td>
                            <div class="dropdown">
                        <span class="dropdown-toggle" id="dropStore1" role="button" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">
                            <span id="dropdown-textorder-{{ $order->id }}">
                            {{$fulfilmentStatuses[$order->fulfilment_status_id]}}
                        </span>
                        </span>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropStore1">
                                    @foreach($fulfilmentStatuses as $key => $fulfilmentStatus)
                                        @if($key != $order->fulfilment_status_id)
                                            <a class="dropdown-item" href="javascript:void(0)"
                                               data-url="{{route('order-status', ['type' => 'fulfilment'])}}"
                                               data-status="{{$key}}"
                                               data-type="put"
                                               data-toggle="modal"
                                               data-modal="modal"
                                               data-target="#confirmModal"
                                               data-title="{{$fulfilmentStatus}}"
                                               data-id="{{$order->id}}"
                                            >{{$fulfilmentStatus}}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </td>
                    @endif
                    <td>
                        <p class="mb-0 order-total">AED {{$order->total}}</p>
                    </td>
                    @if(Auth::user()->id != 1)
                        <td>
                            <div class="table-action">
                                @if(plan_has_permission(['order-edit']))
                                    <a href="{{route('orders-edit',['id' => $order->id])}}" class="edit-order">
                                        <img alt="" src="{{asset('business_assets/images/edit.png')}}">
                                    </a>
                                @endif
                                @if(plan_has_permission(['order-invoice-generate']) || !empty($order->invoice_number))
                                    <a href="{{route('orders-invoice',['id' => $order->id])}}"
                                       class="print-order">
                                        <img alt="" src="{{asset('business_assets/images/print.png')}}">
                                    </a>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @php $paginator = $orders->toArray() @endphp
    <div class="d-flex justify-content-between">
        <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
        {!! $orders->appends(request()->getQueryString())->links() !!}
    </div>
</div>

