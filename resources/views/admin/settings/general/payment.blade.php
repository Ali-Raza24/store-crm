@extends('layouts.admin.app')
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
                        {!! Form::open(['route' => 'admin-payment-setting-save']) !!}
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h4 class="font-weight-700 dark-one">Stripe Information</h4>
                                <hr class="mt-5 mb-5">
                                <div class="row">
                                    <div class="col-sm-12 form-group mb-3">
                                        <label class="font-weight-600 dark-one mb-2">Stripe Api Key</label>
                                        {!! Form::text('stripe_key', optional($payment)->stripe_key, ['class' => 'form-control order-edit-control '.($errors->has('stripe_key') ? 'danger-border' : null)]) !!}
                                        @error('stripe_key')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="font-weight-600 dark-one mb-2">Stripe Api Secret</label>
                                        {!! Form::text('stripe_secret', optional($payment)->stripe_secret, ['class' => 'form-control order-edit-control '.($errors->has('stripe_secret') ? 'danger-border' : null)]) !!}
                                        @error('stripe_secret')
                                        <div class="input-info danger-bg">
                                            <p>{{$message}}</p>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
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
