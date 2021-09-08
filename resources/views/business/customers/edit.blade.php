@extends('layouts.business.app')

@section('stylesheet')
    <link rel="stylesheet" href="{{asset('business_assets/css/customer.css')}}">
@endsection
@section('title','Edit Customer')

@section('header_heading', "Edit Customer")

@section("header_subheading", "About Customer")

@section('content')
    {!! Form::open(['route' => 'customer-store', 'files' => true]) !!}
    <div class="location-update pt-4 mb-4">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label w-100 h-100 pl-4" for="customCheck1"><span
                            class="pl-2">Agree to Subscribe</span></label>
                </div>
            </div>
            <div class="col-6 pl-0">
                <div class="text-right">
                    <a href="{{route('customers-detail',['id' => $customer->id])}}" class="btn-gray btn-rounded btn-size">Cancel</a>
                    <button class="btn-primary btn-rounded btn-size">Update</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        @include('flash::message')
    </div>
    <div class="customer-panel">
        {!! Form::hidden('customer_id',$customer->id) !!}
        {!! Form::hidden('first_name',$customer->first_name) !!}
        {!! Form::hidden('last_name',$customer->last_name) !!}
        <div class="row align-items-center">
            <div class="col-md-4 col-sm-12 text-center">
                <div class="customer-img-panel" id="image">
                    <span>
                        @if($customer->image)
                        <image-upload image_placeholder="{{$customer->image}}" name="images[]"></image-upload>
                        @else
                            <image-upload image_placeholder="{{asset('business_assets/images/customer-img.png')}}"></image-upload>
                        @endif
                        </span>
                    <h3 class="dark-one font-weight-700 mt-3">{!! $customer->name !!}</h3>
                    <p>Member Since {!! \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') !!}</p>
                </div>
            </div>
            <script src="{{asset('js/image.js')}}"></script>
            <div class="col-md-8 col-sm-12 b-l">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Email</h6>
                            <div class="form-group mt-1">
                                {!! Form::email('email', $customer->email, ['class' => 'form-control order-edit-control '.($errors->has('email') ? 'danger-border' : ''), 'disabled']) !!}
                                @error('email')
                                    <div class="input-info danger-bg">
                                        {!! $message !!}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Phone No</h6>
                            <div class="form-group mt-1">
                                {!! Form::number('phone', $customer->phone, ['class' => 'form-control order-edit-control '.($errors->has('phone') ? 'danger-border' : '')]) !!}
                                @error('phone')
                                <div class="input-info danger-bg">
                                    {!! $message !!}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Country</h6>
                            <div class="form-group mt-1">
                                <div class="form-icon">
                                    {!! Form::select('country_id', \App\Helpers\CommonHelper::countries(),$customer->country_id, ['class' => 'form-control order-edit-control '.($errors->has('country_id') ? 'danger-border' : '')]) !!}
                                    @error('country_id')
                                    <div class="input-info danger-bg">
                                        {!! $message !!}
                                    </div>
                                    @enderror
                                    <span><img src="{{asset('business_assets/images/angledown.png')}}" alt=""></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">City</h6>
                            <div class="form-group mt-1">
                                <div class="form-icon">
                                    {!! Form::select('state', \App\Helpers\CommonHelper::states(), $customer->city_id, ['class' => 'form-control order-edit-control '.($errors->has('state') ? 'danger-border' : '')]) !!}
                                    @error('state')
                                    <div class="input-info danger-bg">
                                        {!! $message !!}
                                    </div>
                                    @enderror
                                    <span><img src="{{asset('business_assets/images/angledown.png')}}" alt=""></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">P.O Code</h6>
                            <div class="form-group mt-1">
                                {!! Form::text('zip', $customer->zipcode, ['class' => 'form-control order-edit-control '.($errors->has('zip') ? 'danger-border' : '')]) !!}
                                @error('zip')
                                <div class="input-info danger-bg">
                                    {!! $message !!}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Address</h6>
                            <div class="form-group mt-1">
                                {!! Form::text('address', $customer->address, ['class' => 'form-control order-edit-control '.($errors->has('address') ? 'danger-border' : '')]) !!}
                                @error('address')
                                <div class="input-info danger-bg">
                                    {!! $message !!}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Note</h6>
                            <div class="form-group mt-1">
                                {!! Form::textarea('notes', $customer->notes, ['class' => 'form-control order-edit-control ']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row counter-wrapp scroller-h">
        <x-counter-box column="3" border_color="primary" text_color="primary" title="Number of Orders"
                       total="{{$customer->order_count}}"
                       class="mt-lg-4 mt-3" />
        <x-counter-box column="3" border_color="danger" text_color="danger" title="Amount Spent"
                       total="{{$customer->amount_spent}}"
                       class="mt-lg-4 mt-3" />
        <x-counter-box column="3" border_color="success" text_color="success" title="Shows Discount %"
                       total="{{$customer->fixed_discount}} %"
                       class="mt-lg-4 mt-3" />
        <x-counter-box column="3" border_color="warning" text_color="warning" title="Paid Invoice"
                       total="0"
                       class="mt-lg-4 mt-3" />
    </div>
    <div class="row mt-5">
        <div class="col-xl-4 col-md-12">
            <nav class="tabs-head" id="allOrders">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="Allorders-tab" data-toggle="tab"
                       href="#Allorders" role="tab" aria-selected="true">Customer Orders</a>
                </div>
            </nav>
        </div>
    </div>
    <hr class="m-0">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive scroll-bar-thin">
                <table class="table table-space table-check">
                    <thead>
                    <tr>
{{--                        <th scope="col" class="custom-checkbox">--}}
{{--                            <input type="checkbox" class="custom-control-input" id="customCheck">--}}
{{--                            <label class="custom-control-label" for="customCheck"></label>--}}
{{--                        </th>--}}
                        <th scope="col">Orders No</th>
                        <th scope="col">Store Location</th>
                        <th scope="col">Date</th>
                        <th scope="col">Total</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
{{--                            <td class="custom-checkbox show-selected">--}}
{{--                                <input type="checkbox" class="custom-control-input" id="customCheck{{$loop->iteration+2}}">--}}
{{--                                <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>--}}
{{--                            </td>--}}
                            <td>
                                <div class="table-order-no">
                                    <strong class="dark-one"><a href="{{route('orders-detail',['id' => $order->id])}}">#{{$order->order_number}}</a></strong>
                                    <p class="mb-0">{!! \Carbon\Carbon::parse($order->created_at)->format('M d, Y') !!}</p>
                                </div>
                            </td>
                            <td>
                                <p style="white-space: pre-wrap">{{optional($order->store)->address_1}}</p>
                            </td>
                            <td>
                                <p class="mb-0 order-total">{!! \Carbon\Carbon::parse($order->created_at)->format('M d, Y - H:i A') !!}</p>
                            </td>
                            <td>
                                <p class="mb-0 order-total">{!! $order->total !!}</p>
                            </td>
                            <td>
                                <div class="table-action">
                                    <a href="javascript:void(0)" class="print-order">
                                        <img alt="" src="{{asset('business_assets/images/print.png')}}">
                                    </a>
                                </div>
                            </td>
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
                    <a href="javascript:void(0)" class="item-btn import-option">
                        <span>Import</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn export-option">
                        <span>Export</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('extras')
    <!-- Modal -->
    <div class="modal fade refund-modal" id="cancelRefund" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="font-weight-700 dark-one mb-2">Are You Sure?</h2>
                    <h4 class="font-weight-600 dark-five">Cancel confirmation for order #100785794</h4>
                    <h2 class="danger-text font-weight-700 modal-amount mt-4">$104.67</h2>
                    <p class="font-weight-700 dark-one mb-4">Total Amount</p>
                    <h4 class="dark-two mb-3">Are you sure to cancel this order?</h4>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1"> Order Cancel </a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                        Not </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade refund-modal" id="sureRefund" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="font-weight-700 dark-one mb-2">Are You Sure?</h2>
                    <h4 class="font-weight-600 dark-five">Refunded confirmation for order #100785794</h4>
                    <h2 class="danger-text font-weight-700 modal-amount mt-4">$104.67</h2>
                    <p class="font-weight-700 dark-one mb-4">Total Amount</p>
                    <h4 class="dark-two mb-3">Are you sure to refund this order?</h4>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1"> Refund Amount </a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                        Cancel </a>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('scripts')
    @include('layouts.jquery')
@endsection
