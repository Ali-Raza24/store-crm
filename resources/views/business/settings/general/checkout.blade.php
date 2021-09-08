@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('css')
    <style>.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before{
            color: #fff;
            background-color: transparent;
            border-color: #b3d7ff
        }</style>
@endsection

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.general.navbar')
                <hr class="m-0">
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settCheckout" role="tabpanel"
                         aria-labelledby="settCheckout">
                        <div class="col-12">
                            @include('flash::message')
                        </div>
                      {!! Form::open(['url' => url()->current()]) !!}
                        {!! method_field('PUT') !!}
                            <div class="row">
                                <h4 class="col-12 font-weight-700 dark-one mb-4">
                                    Customer Check Out Options
                                </h4>
                                <div class="col-md-5 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::hidden('checkout[with_mobile]', 1, null) !!}
                                        {{--{!! Form::checkbox('checkout[with_mobile]', 1, check_setting('checkout','with_mobile'), ['class' => 'custom-control-input', 'id' => 'check1', 'readonly' => true]) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check1">
                                            <span class="pl-2"> Checkout with Mobile </span>
                                        </label>--}}
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::hidden('checkout[with_email]', 1, null) !!}
                                        {{--{!! Form::checkbox('checkout[with_email]', 1, check_setting('checkout','with_email'), ['class' => 'custom-control-input', 'id' => 'check2', 'readonly' => true]) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check2">
                                            <span class="pl-2"> Checkout with Email </span>
                                        </label>--}}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="col-12 font-weight-700 dark-one mb-4"> Tipping Option </h4>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::hidden('checkout[tip_option]', 0, null) !!}
                                        {!! Form::checkbox('checkout[tip_option]', 1, check_setting('checkout','tip_option'), ['class' => 'custom-control-input', 'id' => 'check3']) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check3">
                                            <span class="pl-2">Show tipping options at checkout </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{--<hr>
                            <div class="row">
                                <h4 class="col-12 font-weight-700 dark-one mb-4"> Account Creation </h4>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::hidden('checkout[otp_account]', 0, null) !!}
                                        {!! Form::checkbox('checkout[otp_account]', 1, check_setting('checkout','otp_account'), ['class' => 'custom-control-input', 'id' => 'check4']) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check4">
                                            <span class="pl-2">Make Account with OTP </span>
                                        </label>
                                    </div>
                                </div>
                            </div>--}}
                            <hr>
                            <div class="row">
                                <h4 class="col-12 font-weight-700 dark-one mb-4"> Billing Address </h4>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::hidden('checkout[allow_change_billing]', 0) !!}
                                        {!! Form::radio('checkout[allow_change_billing]', 0, check_setting('checkout','allow_change_billing', 0), ['class' => 'custom-control-input', 'id' => 'check5']) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check5">
                                            <span class="pl-2">Billing address same as Shipping address</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::radio('checkout[allow_change_billing]', 1, check_setting('checkout','allow_change_billing'), ['class' => 'custom-control-input', 'id' => 'check6']) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check6">
                                            <span class="pl-2"> Allow customer to change billing address</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php
                        $optionValues = array_column($selectedPlanOptions->toArray(),'values');
                        $optionsList = [];
                        foreach ($optionValues as $value){
                            $seprated = explode(',', $value);
                            if (count($seprated) > 1) {
                                foreach ($seprated as $item) {
                                    $optionsList[] = $item;
                                }
                            }else{
                                $optionsList[] = $value;
                            }
                        }
                        ?>
                        @if(\App\Helpers\ArrayHelper::hasAnyValues(Arr::pluck($selectedPlanOptions, 'option'), [\App\Constants\AppConstants::PLAN_OPTION_PAYMENTS]))
                            <div class="row">
                                <h4 class="col-12 font-weight-700 dark-one mb-4"> Order Payment Options </h4>
                                @if(\App\Helpers\ArrayHelper::hasAnyValues($optionsList, ['cash-on-delivery']))
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::hidden('checkout[cash_payment]', 0, null) !!}
                                        {!! Form::checkbox('checkout[cash_payment]', 1, check_setting('checkout','cash_payment'), ['class' => 'custom-control-input', 'id' => 'check7']) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check7">
                                            <span class="pl-2">Cash on Delivery</span>
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @if(\App\Helpers\ArrayHelper::hasAnyValues($optionsList, ['online-payments']))
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        {!! Form::hidden('checkout[card_payment]', 0, null) !!}
                                        {!! Form::checkbox('checkout[card_payment]', 1, check_setting('checkout','card_payment'), ['class' => 'custom-control-input', 'id' => 'check8']) !!}
                                        <label class="custom-control-label w-100 h-100 pl-4"
                                               for="check8">
                                            <span class="pl-2"> Card Payment</span>
                                        </label>
                                    </div>
                                </div>
                                    @endif
                            </div>
                            <hr>
                        @endif
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <h4 class="col-12 font-weight-700 dark-one mb-4"> Tax </h4>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group custom-checkbox mb-3">
                                                {!! Form::hidden('checkout[tax_inclusive]', 0, null) !!}
                                                {!! Form::checkbox('checkout[tax_inclusive]', 1, check_setting('checkout','tax_inclusive'), ['class' => 'custom-control-input', 'id' => 'check9']) !!}
                                                <label class="custom-control-label w-100 h-100 pl-4"
                                                       for="check9">
                                                    <span class="pl-2">Products price are inclusive of tax</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <h4 class="col-12 font-weight-700 dark-one mb-4"> Tax Value %</h4>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group custom-checkbox mb-3">
                                                {!! Form::number('checkout[tax_value]', check_setting('tax','tax'), ['class' => 'form-control order-edit-control', 'id' => 'check9', 'disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group custom-checkbox mb-3">
                                            {!! Form::hidden('checkout[no_tax]', 0, null) !!}
                                            {!! Form::checkbox('checkout[no_tax]', 1, check_setting('checkout','no_tax'), ['class' => 'custom-control-input', 'id' => 'check10']) !!}
                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                   for="check10">
                                                <span class="pl-2">No Tax</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script>
      let $taxInclusive = $('[name="checkout[tax_inclusive]"]');
      let $notax = $('[name="checkout[no_tax]"]');

      $taxInclusive.on('click', function() {
        if ($notax.is(':checked')) {
          $notax.attr('checked', false).prop('checked', false);
        }
      });

      $notax.on('click', function() {
        if ($taxInclusive.is(':checked')) {
          $taxInclusive.attr('checked', false).prop('checked', false);
        }
      });
    </script>
@endsection
