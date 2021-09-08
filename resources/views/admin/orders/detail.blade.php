@extends('layouts.admin.app')

@section('title','Order Detail')

@section('header_heading', "Order Detail")

@section("header_subheading", "")

@section('content')
    @php
        /**
         * @var $order \App\Models\Order
         * */
    @endphp
    <div class="row">
        <div class="col-xl-8 col-md-8 cls-m-12">
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
                        </tr>
                        </thead>
                        <tbody>
                        <?php $orderTotal = 0; ?>
                        @foreach($order->details as $key => $detail)
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
                                <td>
                                    {!! $detail->qty !!}
                                </td>
                                <td>
                                    {!! $detail->discount_value !!}
                                </td>
                                <td>
                                    <?php
                                    $productTotal = $detail->price * $detail->qty;
                                    $orderTotal += $productTotal;
                                    ?>
                                    <p class="mb-0 order-total">{{format_number($productTotal,2)}}</p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">
                                &nbsp;
                            </td>
                            <td>
                                Total:
                            </td>
                            <td>
                                <h4 class="font-weight-700 danger-text text-right">{{format_number($orderTotal,2)}}</h4>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 cls-m-12">
            <div class="right-side">
                <div class="mb-4">
                    <h3 class="font-weight-700 primary-text mb-2">{!! optional($order->customer)->name !!}</h3>
                    <p>{!! optional($order->customer)->email !!}</p>
                    <p>{!! optional($order->customer)->phone !!}</p>
                    <p>{!! optional($order->customer)->address !!}</p>
                </div>
                <div class="mb-4">
                    <h4 class="font-weight-600 mb-2">Customer Note</h4>
                    <p>{!! $order->customer_notes !!}</p>
                </div>
                <div class="mb-4">
                    <h4 class="font-weight-600 mb-2">Shipping</h4>
                    <p>{!! optional($order->shippingAddress)->name !!}</p>
                    <p>{!! optional($order->shippingAddress)->email !!}</p>
                    <p>{!! optional($order->shippingAddress)->phone !!}</p>
                    <p>{!! optional($order->shippingAddress)->address !!}</p>
                </div>
                <div class="">
                    <h4 class="font-weight-600 mb-2">Billing Address</h4>
                    <p>{!! optional($order->billingAddress)->name !!}</p>
                    <p>{!! optional($order->billingAddress)->email !!}</p>
                    <p>{!! optional($order->billingAddress)->phone !!}</p>
                    <p>{!! optional($order->billingAddress)->address !!}</p>
                </div>
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
@endsection
@section('scripts')
    @include('layouts.jquery')
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
