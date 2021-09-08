@php
    /**
     * @var $order \App\Models\Order
     * */
@endphp
<header class="web-header">
    <div class="container-fluid">
        <div class="mobile-header">
            <a href="{{route('orders-list')}}">
                <h4 class="font-weight-700 dark-one">
                    <img src="{{asset('business_assets/images/arrow-back.png')}}" alt="" class="mr-1"> Back
                </h4>
            </a>
            <img alt="" src="{{asset('images/yabee_logo_mobile.png')}}" class="mobile-brand">
            <div class="mobile-metas">
                <a href="javascript:void(0)" class="notification-page">
                    <img alt="" src="{{asset('business_assets/images/notification.png')}}">
                    <span class="bege"></span>
                </a>
                <span class="header-meta-collapse">
                            <i></i> <i></i> <i></i>
                        </span>
            </div>
        </div>
        <div class="header-flexer">
            <div class="mobile-hide w-100">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <div class="header-lefter">
                            <a href="{{route('orders-list')}}">
                                <h4 class="font-weight-700 dark-one">
                                    <img src="{{asset('business_assets/images/arrow-back.png')}}" alt=""
                                         class="mr-1"> Back
                                </h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-8 text-center">
                        <h3 class="dark-one font-weight-700 mb-2">Order# {{$order->formatted_number}}</h3>
                        <?php $statuses = $order->history()->where('is_comment','=','0')->distinct('status_id')->pluck('status_id')->toArray(); ?>
                        <ul class="pro-progress">
                            @foreach(\App\Helpers\CommonHelper::orderStatus() as $key => $orderStatus)
                                    @if($order->order_status_id == $key && $key == \App\Constants\IStatus::CANCELLED)
                                    <li class="active">
                                        <span>{{$orderStatus}}</span>
                                    </li>
                                        @break
                                    @else
                                        @if($key != \App\Constants\IStatus::CANCELLED)
                                        <li @if(in_array($key, $statuses)) class="active" @endif>
                                            <span>{{$orderStatus}}</span>
                                        </li>
                                        @endif
                                    @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col text-right">
                        @if($order->payment_status_id == \App\Constants\IStatus::PAYMENT_REFUNDED)
                            <strong class="badge badge-info fa-2x">Refunded</strong>
                        @elseif($order->payment_status_id == \App\Constants\IStatus::PAYMENT_PAID)
                            <strong class="badge badge-success fa-2x">Paid</strong>
                        @else
                            <strong class="badge badge-warning fa-2x">Unpaid</strong>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="row mt-4">
    <div class='col-md-12'> @include('flash::message')</div>
    <div class="col">
        <div class="header-lefter mobile-title desktop-hide text-center mt-4">
            <h2 class="dark-one font-weight-700 text-center">Order #{{$order->id}}</h2>
            <ul class="pro-progress">
                @foreach(\App\Helpers\CommonHelper::orderStatus() as $orderStatus)
                    <li class="active">
                        <span>{{$orderStatus}}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="location-update pt-4">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-6 col-sm-6 order-md-1 order-sm-1 order-lg-0 mobile-hide">
            <div class="location">
                <img src="{{asset('business_assets/images/location.png')}}" alt="">
                <p>{{optional($order->store)->name ?? ''}} </p>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="location-status mb-3 mb-lg-0">
                @if(plan_has_permission('order-invoice-generate') || !empty($order->invoice_number))
                <a href="{{route('orders-invoice',['id' => $order->id])}}">
                    <img alt="" src="{{asset('business_assets/images/printer-white.png')}}">
                </a>
                @endif
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="dropProcess" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span id="dropdown-text-{{ $order->id}}">
                                {{optional($order->paymentStatus)->title}}
                             </span>
                    </button>
                    @if(plan_has_permission(['order-payment']))
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropProcess">
                        @foreach(\App\Helpers\CommonHelper::paymentStatus() as $key => $payment_status)
                            @if($key != $order->payment_status_id)
                                <a class="dropdown-item" href="javascript:void(0)"
                                   data-url="{{route('order-status', ['type' => 'payment'])}}"
                                   data-status="{{$key}}"
                                   data-type="put"
                                   data-toggle="modal"
                                   data-modal="modal"
                                   data-target="#confirmModal"
                                   data-title="{{$payment_status}}"
                                   data-id="{{$order->id}}"
                                >{{$payment_status}}</a>
                            @endif
                        @endforeach
                    </div>
                        @endif
                </div>
                @if(plan_has_permission(['order-status']))
                <div class="dropdown">
                    <button class="dropdown-toggle toggle-warning" type="button" id="dropUnpaid"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="dropdown-textorder-{{ $order->id }}">
                            {{optional($order->fulfillmentStatus)->title}}
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropUnpaid">
                        @foreach(\App\Helpers\CommonHelper::fulfilmentStatus() as $key => $fulfillment_status)
                            @if($key != $order->fulfilment_status_id || $key != \App\Constants\IStatus::CANCELLED)
                                <a class="dropdown-item @if((in_array($key, $statuses) || $order->fulfilment_status_id == \App\Constants\IStatus::DELIVERED)) disabled text-black-50 @endif" href="javascript:void(0)"
                                   data-url="{{route('order-status', ['type' => 'fulfilment'])}}"
                                   data-status="{{$key}}"
                                   data-type="put"
                                   data-toggle="modal"
                                   data-modal="modal"
                                   data-target="#confirmModal"
                                   data-title="{{$fulfillment_status}}"
                                   data-id="{{$order->id}}"
                                >{{$fulfillment_status}}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @if($order->delivery_company_id == \App\Constants\AppConstants::DELIVERY_COMPANY_ARAMEX)
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="dropProcess" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span id="dropdown-text-">
                                Aramex Options
                             </span>
                    </button>
                    <?php
                    $aramexShipping = App\Models\DeliveryCompanyResponses::whereOrderId($order->id)->whereType(App\Constants\AppConstants::ARAMEX_SHIPPING)->first();
                    $aramexLabelPrint = App\Models\DeliveryCompanyResponses::whereOrderId($order->id)->whereType(App\Constants\AppConstants::ARAMEX_LABEL_PRINT)->first();
                    $aramexPickUp = App\Models\DeliveryCompanyResponses::whereOrderId($order->id)->whereType(App\Constants\AppConstants::ARAMEX_PICKUP)->first();
                    ?>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropProcess">
                        <a class="dropdown-item @if(!empty($aramexShipping->tracking_id)) disabled text-black-50 @endif" href="javascript:void(0)"
                           data-url="{{route('aramex-shipment-create', ['id' => $order->id])}}"
                           data-type="post"
                           data-toggle="modal"
                           data-modal="modal"
                           data-target="#confirmModal"
                           data-title="Create Shipment"
                           data-id="{{$order->id}}"
                        >Create Shipment</a>
                        @if(!empty($aramexShipping->tracking_id))
                        <a class="dropdown-item @if(!empty($aramexLabelPrint->tracking_id)) disabled text-black-50 @endif" href="javascript:void(0)"
                           data-url="{{route('aramex-label-print', ['id' => $aramexShipping->tracking_id])}}"
                           data-type="post"
                           data-toggle="modal"
                           data-modal="modal"
                           data-target="#confirmModal"
                           data-title="Create Shipment"
                           data-id="{{$order->id}}"
                        >Print Label</a>
                        @endif
                        <a class="dropdown-item @if(!empty($aramexPickUp->tracking_id)) disabled text-black-50 @endif" href="javascript:void(0)"
                           data-url="{{route('aramex-pickup-create', ['id' => $order->id])}}"
                           data-type="post"
                           data-toggle="modal"
                           data-modal="modal"
                           data-target="#confirmModal"
                           data-title="Create Shipment"
                           data-id="{{$order->id}}"
                        >Create Pickup</a>
                    </div>
                </div>
                @endif
                @if(!empty($aramexShipping->tracking_id) && !empty($aramexLabelPrint))
                    <a class="btn-rounded btn-size btn-primary" href="{{(json_decode($aramexLabelPrint->response_data))->url}}" target="_blank"
                    >Print Label</a>
                @endif
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 order-md-1 order-sm-1 order-lg-0 desktop-hide">
            <div class="location">
                <img src="{{asset('business_assets/images/location.png')}}" alt="">
                <p><p>{{optional($order->store)->name ?? ''}} </p></p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 order-md-2 order-sm-2 order-lg-2">
            <div class="order-update text-right">
                @if(request()->routeIs('orders-edit'))
                    @if(plan_has_permission(['order-edit']))
                    <a onclick='return submitOrderForm();' class="btn-primary btn-rounded">Order Update</a>
                        @endif
                @else
                    @if($order->fulfilment_status_id == \App\Constants\IStatus::CANCELLED)
                        <a href="javascript:void(0);" class="btn-white btn-rounded btn-size">
                            Cancelled
                        </a>
                    @else
                        <a href="{{route('orders-edit',['id' => $order->id])}}" class="mr-4 d-inline-block"><h6
                                    class="font-weight-700">Edit</h6></a>
                        @if(plan_has_permission(['order-cancel']))
                        <a href="{{route('orders-cancel', ['id' => $order->id]) }}" class="btn-white btn-rounded btn-size">
                            Cancel Order
                        </a>
                            @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
