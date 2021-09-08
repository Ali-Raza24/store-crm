@extends('layouts.business.app')

@section('title','Order Invoice')

@section('header_heading', "Order Invoice")

@section("header_subheading", "")

@section('stylesheet')
    <link rel="stylesheet" href="{{asset('business_assets/css/pdf-generator.css')}}">
@endsection

@section('content')
    @php
        /***
         *
         * @var $order \App\Models\Order
         ***/
    @endphp
    <div class="row">
        <div class="col-xl-8 col-md-8 cls-m-12 invoice">
            <div class="default-box mt-5">
                <div id="first-page">
                    <div class="header-lefter d-flex justify-content-between align-items-center">
                        <h2 class="dark-one font-weight-700">{{Auth::user()->business->name}}</h2>
                    </div>
                    <div class="header-lefter d-flex justify-content-between align-items-center mt-3">
                        <h3 class="tagline dark-one font-weight-600">Invoice</h3>
                        <p>Date: {!! \Carbon\Carbon::now()->format('d-m-Y') !!}</p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="@if(!optional($order->billingAddress)->same_address) col-xl-3 @else col-xl-7 @endif col-lg-6 col-sm-12">
                            <div class="bill-to">
                                <h4 class="dark-one font-weight-700">Bill to</h4>
                                <h5 class="dark-one font-weight-700">{{optional($order->billingAddress)->name}}</h5>
                                <p>{!! optional($order->billingAddress)->address !!} </p>
                            </div>
                        </div>
                        @if(!optional($order->billingAddress)->same_address)
                        <div class="col-xl-4 col-lg-6 col-sm-12">
                            <div class="ship-to">
                                <h4 class="dark-one font-weight-700">Ship to</h4>
                                <h5 class="dark-one font-weight-700">{{optional($order->shippingAddress)->name}}</h5>
                                <p>P.O. Box {{optional($order->shippingAddress)->zipcode}}, {{optional(optional($order->shippingAddress)->area)->title}}, {{optional(optional($order->shippingAddress)->city)->name}}, UAE</p>
                                <p>Tel +{{optional($order->shippingAddress)->phone}}</p>
                            </div>
                        </div>
                        @endif
                        <div class="@if(!optional($order->billingAddress)->same_address) col-xl-5 @else col-xl-5 @endif col-lg-12 col-sm-12">
                            <div class="invoice-number">
                                <h4 class="dark-one font-weight-700">Invoice No. #{{$order->invoice_number}}</h4>
                                <img src="{{asset('business_assets/images/barcode.png')}}" alt="image">
                                <div class="other-info">
                                    <p>Payment:</p>
                                    <h6 class="dark-one p-0 m-0 font-weight-700">{{ isset($order->payment) ? $order->payment->payment_type_id : 'Cash On Delivery'}}</h6>
                                </div>
                                <div class="other-info">
                                    <p>Shipping:</p>
                                    <h5 class="dark-one font-weight-700">{{ $order->delivery_company_id == 0 ? 'Standard' : $order->deliveryCompany->title}}</h5>
                                </div>
                                <div class="other-info">
                                    <p>Email:</p>
                                    <h5 class="dark-one font-weight-700">{!! optional($order->shippingAddress)->email !!} </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive scroll-bar-thin">
                        <table class="table table-space v-middle order-table">
                            <thead>
                            <tr>
                                <th scope="col">Item Description</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Price</th>
                                <th scope="col" class="text-right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            /***
                             *
                             * @var $detail \App\Models\OrderDetail
                             ***/
                            $orderTotal = 0;
                            $subTotal = 0;
                            @endphp
                            @foreach($order->details as $detail)
                            <tr>
                                <td>
                                    <div class="same-td">
                                        <div class="pro-img">
                                            <img src="{{ isset($detail->product->main_image) ? $detail->product->main_image : asset('img/camera_icon.png') }}" alt="image">
                                        </div>
                                        <div class="righter">
                                            <p class="order-detail-product dark-one font-weight-700 mb-0">{!! $detail->product->title !!}</p>
                                            <small class="order-detail-tagline dark-three">{!! substr($detail->product->description,1,20) !!}</small>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    X {!! $detail->qty !!}
                                </td>
                                <td>
                                    <p class="mb-0 order-total">{!! currency_format($detail->price) !!}</p>
                                </td>
                                <td class="text-right">
                                    <?php
                                    $productTotal = $detail->price * $detail->qty;
                                    $subTotal += $productTotal;
                                    ?>
                                    <p class="mb-0 order-total">{{currency_format($productTotal)}}</p>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <ul class="invoice-subtotal">
                            <li>
                                <span> Subtotal: </span>
                                <span>{{currency_format($subTotal)}}</span>
                            </li>
                            <li>
                                <span>Tip:</span>
                                <span>{!! currency_format($order->tip_amount) !!}</span>
                            </li>
                            <li>
                                <span>Delivery Charges:</span>
                                <span>{!! currency_format($order->delivery_charges) !!}</span>
                            </li>
                            <li>
                                <span>Discount Amount</span>
                                <span>{!! currency_format($order->discount) !!}</span>
                            </li>
                            @if(!check_setting('checkout','no_tax'))
                                @if(check_setting('checkout','tax_inclusive'))
                            <li>
                                <span>Tax:</span>
                                <span>{!! currency_format($order->tax) !!}</span>
                            </li>
                                @endif
                                @endif
                            <li>
                                <span>Total (incl. VAT):</span>
                                <?php $orderTotal += $subTotal; ?>
                                <?php $orderTotal += $order->delivery_charges; ?>
                                <?php $orderTotal += $order->tip_amount; ?>
                                <?php $orderTotal -= $order->discount; ?>
                                <?php $orderTotal += $order->tax; ?>
                                <span>{!! currency_format($orderTotal) !!}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="invoice-thanks">
                        <h3>Thank you!</h3>
                        <p>Don't forget to leave a review so we know how we're doing
                            and tag us on your posts {!! '@'.Auth::user()->business->name !!} {!! '#'.Auth::user()->business->name !!}</p>
                    </div>
                    <div class="invoice-blooms">
                        <h3>{!! Auth::user()->business->name !!}</h3>
                        <p>{!! Auth::user()->business->address_1 !!}</p>
                        <p>{!! Auth::user()->business->email !!} / {!! Auth::user()->business->phone !!}</p>
                        <p>TRN: {{check_setting('invoice','trn_number')}}</p>
                        <p class="mailer"> {!! Auth::user()->business->email !!} </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 cls-m-12 no-print">
            <div class="right-side pl-0 pr-0 mt-5">
                <div class="mb-4">
                    <h4 class="font-weight-700 dark-one mb-4 pt-1 pl-4 pr-4">Print Options</h4>
                    <hr>
                    <div class="mb-4 pt-3 pl-4 pr-4">
                        <div class="custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label w-100 h-100 pl-4" for="customCheck1"><span
                                    class="pl-2">Print Receipt</span></label>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-4 pt-3 pl-4 pr-4">
                        <div class="custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label w-100 h-100 pl-4" for="customCheck2"><span
                                    class="pl-2">Print Invoice</span></label>
                        </div>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)" class="btn-size btn-dark btn-rounded pl-5 pr-5"
               id="exportForm">Print</a>
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
                        <a href="javascript:void(0)"><img src="{{asset('business_assets/images/printer-white.png')}}" alt="image"> Print
                            Options</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
    <div class="col-xl-8 col-md-8 cls-m-12 col-print-12" id="invoice-print">
        <div class="default-box mt-5">
            <div id="first-page">
                <div class="header-lefter d-flex justify-content-between align-items-center">
                    <h2 class="dark-one font-weight-700">{{Auth::user()->business->name}}</h2>
                </div>
                <div class="header-lefter d-flex justify-content-between align-items-center mt-3">
                    <h3 class="tagline dark-one font-weight-600">Invoice</h3>
                    <p>Date: {!! \Carbon\Carbon::now()->format('d-m-Y') !!}</p>
                </div>
                <hr>
                <div class="row">
                    <div class="@if(!optional($order->billingAddress)->same_address) col-xl-3 col-print-3 @else col-xl-7 col-print-7 @endif col-lg-6 col-sm-12">
                        <div class="bill-to">
                            <h4 class="dark-one font-weight-700">Bill to</h4>
                            <h5 class="dark-one font-weight-700">{{optional($order->billingAddress)->name}}</h5>
                            <p>{!! optional($order->billingAddress)->address !!} </p>
                        </div>
                    </div>
                    @if(!optional($order->billingAddress)->same_address)
                        <div class="col-xl-4 col-lg-6 col-sm-12 col-print-4">
                            <div class="ship-to">
                                <h4 class="dark-one font-weight-700">Ship to</h4>
                                <h5 class="dark-one font-weight-700">{{optional($order->shippingAddress)->name}}</h5>
                                <p>P.O. Box {{optional($order->shippingAddress)->zipcode}}, {{optional(optional($order->shippingAddress)->area)->title}}, {{optional(optional($order->shippingAddress)->city)->name}}, UAE</p>
                                <p>Tel +{{optional($order->shippingAddress)->phone}}</p>
                            </div>
                        </div>
                    @endif
                    <div class="@if(!optional($order->billingAddress)->same_address) col-xl-5 col-print-5 @else col-xl-5 col-print-5 @endif col-lg-12 col-sm-12">
                        <div class="invoice-number">
                            <h4 class="dark-one font-weight-700">Invoice No. #{{$order->invoice_number}}</h4>
                            <img src="{{asset('business_assets/images/barcode.png')}}" alt="image">
                            <div class="other-info">
                                <p>Payment:</p>
                                <h6 class="dark-one p-0 m-0 font-weight-700">{{ isset($order->payment) ? $order->payment->payment_type_id : 'Cash On Delivery'}}</h6>
                            </div>
                            <div class="other-info">
                                <p>Shipping:</p>
                                <h5 class="dark-one font-weight-700">{{ $order->delivery_company_id == 0 ? 'Standard' : $order->deliveryCompany->title}}</h5>
                            </div>
                            <div class="other-info">
                                <p>Email:</p>
                                <h5 class="dark-one font-weight-700">{!! optional($order->shippingAddress)->email !!} </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive scroll-bar-thin">
                    <table class="table table-space v-middle order-table">
                        <thead>
                        <tr>
                            <th scope="col">Item Description</th>
                            <th scope="col">QTY</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            /***
                             *
                             * @var $detail \App\Models\OrderDetail
                             ***/
                            $orderTotal = 0;
                            $subTotal = 0;
                        @endphp
                        @foreach($order->details as $detail)
                            <tr>
                                <td>
                                    <div class="same-td">
                                        <div class="pro-img">
                                            <img src="{{ isset($detail->product->main_image) ? $detail->product->main_image : asset('img/camera_icon.png') }}" alt="image">
                                        </div>
                                        <div class="righter">
                                            <p class="order-detail-product dark-one font-weight-700 mb-0">{!! $detail->product->title !!}</p>
                                            <small class="order-detail-tagline dark-three">{!! substr($detail->product->description,1,20) !!}</small>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    X {!! $detail->qty !!}
                                </td>
                                <td>
                                    <p class="mb-0 order-total">{!! currency_format($detail->price) !!}</p>
                                </td>
                                <td class="text-right">
                                    <?php
                                    $productTotal = $detail->price * $detail->qty;
                                    $subTotal += $productTotal;
                                    ?>
                                    <p class="mb-0 order-total">{{currency_format($productTotal)}}</p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <ul class="invoice-subtotal">
                        <li>
                            <span> Sub Total: </span>
                            <span>{{currency_format($subTotal)}}</span>
                        </li>
                        <li>
                            <span>Tip:</span>
                            <span>{!! currency_format($order->tip_amount) !!}</span>
                        </li>
                        <li>
                            <span>Delivery Charges:</span>
                            <span>{!! currency_format($order->delivery_charges) !!}</span>
                        </li>
                        <li>
                            <span>Discount Amount</span>
                            <span>{!! currency_format($order->discount) !!}</span>
                        </li>
                        @if(check_setting('checkout','no_tax'))
                            @if(check_setting('checkout','tax_inclusive'))
                        <li>
                            <span>Tax:</span>
                            <span>{!! currency_format($order->tax) !!}</span>
                        </li>
                            @endif
                        @endif
                        <li>
                            <span>Total (incl. VAT):</span>
                            <?php $orderTotal += $subTotal; ?>
                            <?php $orderTotal += $order->delivery_charges; ?>
                            <?php $orderTotal += $order->tip_amount; ?>
                            <?php $orderTotal -= $order->discount; ?>
                            <?php $orderTotal += $order->tax; ?>
                            <span>{!! currency_format($orderTotal) !!}</span>
                        </li>
                    </ul>
                </div>
                <div class="invoice-thanks">
                    <h3>Thank you!</h3>
                    <p>Don't forget to leave a review so we know how we're doing
                        and tag us on your posts {!! '@'.Auth::user()->business->name !!} {!! '#'.Auth::user()->business->name !!}</p>
                </div>
                <div class="invoice-blooms">
                    <h3>{!! Auth::user()->business->name !!}</h3>
                    <p>{!! Auth::user()->business->address_1 !!}</p>
                    <p>{!! Auth::user()->business->email !!} / {!! Auth::user()->business->phone !!}</p>
                    <p>TRN: {{check_setting('invoice','trn_number')}}</p>
                    <p class="mailer"> {!! Auth::user()->business->email !!} </p>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('css')

    <style>
        #invoice-print{
            display: none;
        }
        @media print {
            .col-print-1 {
                flex: 0 0 8.33333%;
                max-width: 8.33333%; } }

        @media print {
            .col-print-2 {
                flex: 0 0 16.66667%;
                max-width: 16.66667%; } }

        @media print {
            .col-print-3 {
                flex: 0 0 25%;
                max-width: 25%; } }

        @media print {
            .col-print-4 {
                flex: 0 0 33.33333%;
                max-width: 33.33333%; } }

        @media print {
            .col-print-5 {
                flex: 0 0 41.66667%;
                max-width: 41.66667%; } }

        @media print {
            .col-print-6 {
                flex: 0 0 50%;
                max-width: 50%; } }

        @media print {
            .col-print-7 {
                flex: 0 0 58.33333%;
                max-width: 58.33333%; } }

        @media print {
            .col-print-8 {
                flex: 0 0 66.66667%;
                max-width: 66.66667%; } }

        @media print {
            .col-print-9 {
                flex: 0 0 75%;
                max-width: 75%; } }

        @media print {
            .col-print-10 {
                flex: 0 0 83.33333%;
                max-width: 83.33333%; } }

        @media print {
            .col-print-11 {
                flex: 0 0 91.66667%;
                max-width: 91.66667%; } }

        @media print {
            .col-print-12 {
                flex: 0 0 100%;
                max-width: 100%; }
        }
        @media print {
            main {
                display: none;
            }
            #invoice-print {
                display: block !important;
            }
            tr{
                border-bottom: 1px solid #A1B1BC;
                border-radius: 0;
            }
        }
    </style>
@endsection

@section('scripts')
    @include('layouts.jquery')
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js'></script>
    <script>
        $('#exportForm').click(function () {
          window.print()
            /*var pdf = new jsPDF('a', 'mm', 'a4');
            var firstPage;
            // var secondPage;

            html2canvas($('#first-page'), {
                onrendered: function (canvas) {
                    firstPage = canvas.toDataURL('image/jpeg', 1.0);
                }
            });

            // html2canvas($('#second-page'), {
            //     onrendered: function (canvas) {
            //         secondPage = canvas.toDataURL('image/jpeg', 1.0);
            //     }
            // });


            setTimeout(function () {
                pdf.addImage(firstPage, 'JPEG', 5, 5, 200, 0);
                pdf.addPage();
                // pdf.addImage(secondPage, 'JPEG', 5, 5, 200, 0);
                pdf.save("export.pdf");
            }, 150);*/
        });
    </script>
@endsection
