@extends('layouts.admin.app')

@section('title', 'Aramex')
@section('heading', 'Aramex')

@section('content')
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">Settings</h2>
                <h4 class="tagline dark-one font-weight-400">Quick Overview</h4>
            </div>
        </div>
    </div>

    <div class="row setting-wrapp">
        <div class="col-lg-4">
            @include('admin.settings.sidebar')
        </div>
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('admin.settings.general.navbar')
                <hr class="m-0" />
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settStore" role="tabpanel" aria-labelledby="settStore">
                        <div class="col-12">
                            @include('flash::message')
                        </div>
                        {!! Form::open(['route' => 'aramex-integrate']) !!}
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h4 class="font-weight-700 dark-one">Account Information</h4>
                                <hr class="mt-5 mb-5">
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Username (Email)</label>
                                        {!! Form::text('email', optional($aramex)->email, ['class' => 'form-control order-edit-control '.($errors->has('email') ? 'danger-border' : null)]) !!}
                                        @error('email')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Password</label>
                                        {!! Form::text('password', optional($aramex)->password, ['class' => 'form-control order-edit-control '.($errors->has('password') ? 'danger-border' : null)]) !!}
                                        @error('password')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Account Number</label>
                                        {!! Form::text('account_number', optional($aramex)->account_number, ['class' => 'form-control order-edit-control '.($errors->has('account_number') ? 'danger-border' : null)]) !!}
                                        @error('account_number')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Account Pin</label>
                                        {!! Form::text('account_pin', optional($aramex)->account_pin, ['class' => 'form-control order-edit-control '.($errors->has('account_pin') ? 'danger-border' : null)]) !!}
                                        @error('account_pin')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Account Entity</label>
                                        {!! Form::text('account_entity', optional($aramex)->account_entity, ['class' => 'form-control order-edit-control '.($errors->has('account_entity') ? 'danger-border' : null)]) !!}
                                        @error('account_entity')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Account Country Code</label>
                                        {!! Form::text('account_country_code', optional($aramex)->account_country_code, ['class' => 'form-control order-edit-control '.($errors->has('account_country_code') ? 'danger-border' : null)]) !!}
                                        @error('account_country_code')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h4 class="font-weight-700 dark-one">Shipping Defaults</h4>
                                <hr class="mt-5 mb-5">
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Default Product Group</label>
                                        <div class="form-icon">
                                            {!! Form::select('default_product_group', \App\Helpers\CommonHelper::aramexProductGroups(), optional($aramex)->default_product_group, ['class' => 'form-control order-edit-control '.($errors->has('default_product_group') ? 'danger-border' : null)]) !!}
                                            @error('default_product_group')
                                            <div class="input-info danger-bg">
                                                <p>{{$message}}</p>
                                            </div>
                                            @enderror
                                            <span>
                                                <img src="{{asset('business_assets/images/angledown.png')}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Default Payment Type</label>
                                        <div class="form-icon">
                                        {!! Form::select('default_payment_type', \App\Helpers\CommonHelper::aramexPaymentTypes(), optional($aramex)->default_payment_type, ['class' => 'form-control order-edit-control '.($errors->has('default_payment_type') ? 'danger-border' : null)]) !!}
                                        @error('default_payment_type')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                            <span>
                                                <img src="{{asset('business_assets/images/angledown.png')}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Default Product Type</label>
                                        <div class="form-icon">
                                        {!! Form::select('default_product_type', \App\Helpers\CommonHelper::aramexProductTypes(), optional($aramex)->default_product_type, ['class' => 'form-control order-edit-control '.($errors->has('default_product_type') ? 'danger-border' : null)]) !!}
                                        @error('default_domestic_product_type')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                        <span>
                                                <img src="{{asset('business_assets/images/angledown.png')}}" alt="">
                                            </span>
                                    </div>
                                    </div>
                                </div>

                                {{--<div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Default International Product Type</label>
                                        {!! Form::text('default_international_product_type', optional($aramex)->default_international_product_type, ['class' => 'form-control order-edit-control '.($errors->has('default_international_product_type') ? 'danger-border' : null)]) !!}
                                        @error('default_international_product_type')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>--}}

                                {{--<div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Default Payment Option</label>
                                        {!! Form::text('default_payment_option', optional($aramex)->default_payment_option, ['class' => 'form-control order-edit-control '.($errors->has('default_payment_option') ? 'danger-border' : null)]) !!}
                                        @error('default_prepaid_payment_option')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>--}}

                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <hr class="mt-5 mb-3" />
                            <button class="btn-size btn-rounded btn-primary mr-3">Update</button>
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
      //show Discount Edit view
      @if(!empty($showTestimonialEdittab) || $errors->any())
      $('body').toggleClass('customer-modal');
      @endif
      function uploadDialog () {
        $('#imgupload').trigger('click');
      }
    </script>
@endsection
