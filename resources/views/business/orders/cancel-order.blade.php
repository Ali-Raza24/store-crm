@extends('layouts.business.app')

@section('title','Order Detail')

@section('header_heading', "Order Detail")

@section("header_subheading", "")

@section('content')
    @php
        /**
         * @var $order \App\Models\Order
         * */
    @endphp
    <div class="location-update pt-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6 col-sm-12">
                <div class="location">
                    <img src="{{asset('business_assets/images/location.png')}}" alt="">
                    <p>{{optional($order->store)->address_1 ?? ''}}</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="order-update text-right">
                    @if($order->order_status_id != \App\Constants\IStatus::CANCELLED)
                    <a href="javascript:void(0)" class="btn-red btn-rounded btn-size" data-toggle="modal"
                       data-target="#cancelRefund">Cancel Order</a>
                    @else
                        <button class="btn-red btn-rounded btn-size disabled" disabled data-toggle="modal"
                           data-target="#cancelRefund">Cancelled</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-9 col-md-8 cls-m-12">
            <div class="sf-order">
                <div class="table-responsive scroll-bar-thin">
                    <table class="table table-space first-tran v-middle order-table">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Product</th>
                            <th scope="col">Category</th>
                            <th scope="col">QTY</th>
                            <th scope="col">Discount %</th>
                            <th scope="col">Price</th>
{{--                            <th scope="col"></th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        <?php $orderTotal = 0; ?>
                        @foreach($order->details as $detail)
                            <tr>
                            <td>
                                <div class="pro-img">
                                    @if($detail['product']['url'])
                                        <img src="{{ $orderProduct['product']['url'] }}" alt="image">
                                    @else
                                        <img src="{{asset('img/camera_icon.png')}}" alt="image">
                                    @endif
                                </div>
                            </td>
                            <td>
                                <p class="order-detail-product dark-one font-weight-600 mb-0">{!! optional($detail->product)->title !!}</p>
                                <small class="order-detail-tagline dark-two"></small>
                            </td>
                            <td>
                                {!! optional($detail->category)->title !!}
                            </td>
                            <td class="border-dropdown">
                                <input type="text" value="{!! $detail->qty !!}" class="form-control">
                            </td>
                            <td>
                                {!! $detail->discount_value !!}
                            </td>
                            <td>
                                <?php
                                $productTotal = $detail->price * $detail->qty;
                                $orderTotal += $productTotal;
                                ?>
                                <p class="mb-0 order-total">{{$productTotal}}</p>
                            </td>

                            {{--<td>
                                <a href="javascript:void(0)"><img src="{{asset('business_assets/images/delete.png')}}" alt="image"></a>
                            </td>--}}
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 cls-m-12">
            <div class="right-side">
                <div class="mb-4">
                    <h4 class="font-weight-700 dark-one mb-2">Amount Refund</h4>
                    <p class="mb-0">Order Amount:</p>
                    <h2 class="static-sign">
                        <input class="refund-control font-weight-700 dark-one" value="{{$order->subtotal}}">
                        <span class="dollar-sign font-weight-700 dark-one">AED</span>
                    </h2>
                    <hr>
                    <p class="mb-0">Shipping Amount:</p>
                    <h2 class="static-sign">
                        <input class="refund-control font-weight-700 dark-two" value="{{$order->delivery_charges}}">
                        <span class="dollar-sign font-weight-700 dark-two">AED</span>
                    </h2>
                    <hr>
                    <p class="mb-0">Total Amount:</p>
                    <h2 class="font-weight-700 danger-text">AED {{$orderTotal}}</h2>
                    <hr>
                </div>
                @if(plan_has_permission(['order-refund']))
                @if($order->payment_status_id != \App\Constants\IStatus::PAYMENT_REFUNDED)
                    <a href="javascript:void(0)" class="btn-size btn-primary btn-rounded" data-toggle="modal"
                       data-target="#sureRefund">Refund Amount</a>
                @else
                    <button class="btn-primary btn-rounded btn-size disabled" disabled data-toggle="modal"
                            data-target="#sureRefund">Refunded</button>
                @endif
                    @endif
            </div>
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
                        <a href="javascript:void(0)"><img src="{{asset('business_assets/images/writing-white.png')}}" alt="image"> Note</a>
                        <a href="javascript:void(0)">Multi Fulfill</a>
                        <a href="javascript:void(0)">Capture Payment</a>
                        <a href="javascript:void(0)"><img src="{{asset('business_assets/images/printer-white.png')}}" alt="image"> Print Options</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extras')
    <!-- Modal -->
    <div class="modal fade refund-modal" id="cancelRefund" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{route('order-status',['type'=>'order'])}}" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" id="method">
                        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                        <input type="hidden" name="status_id" id="status_id" value="{{\App\Constants\IStatus::CANCELLED}}">
                        <h2 class="font-weight-700 dark-one mb-2">Are You Sure?</h2>
                        <h4 class="font-weight-600 dark-five">Cancel confirmation for order #{{$order->id}}</h4>
                        <h2 class="danger-text font-weight-700 modal-amount mt-4">${{$orderTotal}}</h2>
                        <p class="font-weight-700 dark-one mb-4">Total Amount</p>
                        <h4 class="dark-two mb-3">Are you sure to cancel this order?</h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"> Order Cancel </button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                            Not </a>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade refund-modal" id="sureRefund" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{route('order-status',['type'=>'payment'])}}" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" id="method">
                        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                        <input type="hidden" name="status_id" id="status_id" value="{{\App\Constants\IStatus::PAYMENT_REFUNDED}}">
                        <h2 class="font-weight-700 dark-one mb-2">Are You Sure?</h2>
                        <h4 class="font-weight-600 dark-five">Refunded confirmation for order #{{$order->id}}</h4>
                        <h2 class="danger-text font-weight-700 modal-amount mt-4">${{$orderTotal}}</h2>
                        <p class="font-weight-700 dark-one mb-4">Total Amount</p>
                        <h4 class="dark-two mb-3">Are you sure to refund this order?</h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"> Refund Amount </button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                            Not </a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @include('layouts.jquery')
@endsection
