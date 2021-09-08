@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.general.navbar')
                <hr class="m-0">
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settNotificat" role="tabpanel"
                         aria-labelledby="settNotificat">
                        {!! Form::open(['url' => url()->current()]) !!}
                        @include('flash::message')
                        {!! method_field('PUT') !!}

                        <div class="form-group custom-checkbox mb-3">
                            <label class="font-weight-500 dark-one" for="note1">TRN Number</label>
                            {!! Form::text('invoice[trn_number]', old('invoice.trn_number') ?? optional($invoice)->trn_number, ['class' => 'form-control order-edit-control '.($errors->has('invoice.trn_number') ? 'border-danger' :'')]) !!}
                            @error('invoice.trn_number')
                            <div class="input-info danger-bg">
                                {!! $message !!}
                            </div>
                            @enderror
                        </div>
                        <hr class="mt-5 mb-5">

                        <h4 class="font-weight-700 dark-one mb-4">Invoice</h4>
                        @if(session()->has('invoice'))
                            <div class="alert alert-success">
                                {!! session()->get('invoice') !!}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group custom-checkbox mb-3">
                                    <label class="font-weight-500 dark-one" for="note1">Start From</label>
                                    @if(isset($invoice->invoice_start))
                                        {!! Form::hidden('invoice[invoice_start]', optional($invoice)->invoice_start,) !!}
                                    @endif
                                    {!! Form::text('invoice[invoice_start]', optional($invoice)->invoice_start, ['class' => 'form-control order-edit-control '.($errors->has('invoice.invoice_start') ? 'border-danger' :'') ,isset($invoice->invoice_start) ? 'disabled' : '']) !!}
                                    @error('invoice.invoice_start')
                                    <div class="input-info danger-bg">
                                        {!! $message !!}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group custom-checkbox mb-3">
                                    <label class="font-weight-500 dark-one" for="note1">Prepend to invoice number</label>
                                    {!! Form::text('invoice[prepend_invoice]', optional($invoice)->prepend_invoice, ['class' => 'form-control order-edit-control '.($errors->has('invoice.prepend_invoice') ? 'border-danger' :'')]) !!}
                                    @error('invoice.prepend_invoice')
                                    <div class="input-info danger-bg">
                                        {!! $message !!}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{--<hr class="mt-4 mb-4">
                        <h4 class="font-weight-700 dark-one mb-4">Orders</h4>
                        @if(session()->has('order'))
                            <div class="alert alert-success">
                                {!! session()->get('order') !!}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group custom-checkbox mb-3">
                                    <label class="font-weight-500 dark-one" for="note1">Start From</label>
                                    {!! Form::text('order[order_start]', optional($order)->order_start, ['class' => 'form-control order-edit-control '.($errors->has('order.order_start') ? 'border-danger' :'')]) !!}
                                    @error('order.order_start')
                                    <div class="input-info danger-bg">
                                        {!! $message !!}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group custom-checkbox mb-3">
                                    <label class="font-weight-500 dark-one" for="note1">Prepend to order number</label>
                                    {!! Form::text('order[prepend_order]', optional($order)->prepend_order, ['class' => 'form-control order-edit-control '.($errors->has('order.prepend_order') ? 'border-danger' :'')]) !!}
                                    @error('order.prepend_order')
                                    <div class="input-info danger-bg">
                                        {!! $message !!}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>--}}
                        <div class="form-group mb-0 text-right">
                            <hr class="mt-5 mb-3">
                            <button class="btn-size btn-rounded btn-primary mr-3">
                                Update
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
@endsection
