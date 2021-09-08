@extends('layouts.app')

@section('title','Downgrade')

@section('css')
    <style>
        .cards-2 {
            padding-top: 3rem;
            padding-bottom: 2.75rem;
            text-align: center;
        }

        .cards-2 h2 {
            margin-bottom: 1rem;
        }

        .cards-2 .card {
            display: block;
            width: 100%;
            margin-right: auto;
            margin-bottom: 6rem;
            margin-left: auto;
            border: 1px solid #c4d8dc;
            border-radius: 0.5rem;
            vertical-align: top;
        }
        .card.select-price{
            border-width:3px;
            cursor: pointer;
        }
        .card.active-tab{
            border-color:#26e38f;
        }

        .cards-2 .card .card-body {
            padding: 2.5rem 2.75rem 1.875rem 2.5rem;
        }

        .cards-2 .card .card-title {
            margin-bottom: 0.625rem;
            color: #393939;
            font-weight: 700;
            font-size: 1.75rem;
            line-height: 0.25rem;
            text-align: center;
        }

        .cards-2 .card .card-subtitle {
            margin-bottom: .55rem;
        }

        .cards-2 .card .cell-divide-hr {
            height: 1px;
            margin-top: 0;
            margin-bottom: 0;
            border: none;
            background-color: #c4d8dc;
        }

        .cards-2 .card .price {
            padding-top: 0.125rem;
            padding-bottom: 0.5rem;
        }

        .cards-2 .card .value {
            /*color: #26e38f;*/
            font-weight: 700;
            font-size: 3.5rem;
            line-height: 4rem;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .cards-2 .card .currency {
            margin-right: 0.375rem;
            /*color: #26e38f;*/
            font-size: 1.5rem;
            vertical-align: 56%;
        }

        .cards-2 .card .frequency {
            margin-top: 0.25rem;
            font-size: 0.875rem;
            text-align: center;
        }

        .cards-2 .card .list-unstyled {
            margin-top: 0.875rem;
            margin-bottom: 0.375rem;
            text-align: left;
        }

        .cards-2 .card .list-unstyled.li-space-lg li {
            margin-bottom: 0.5rem;
        }

        .cards-2 .card .list-unstyled .fas {
            color: #26e38f;
            line-height: 1.375rem;
        }

        .cards-2 .card .list-unstyled .fas.fa-times {
            margin-left: 0.1875rem;
            margin-right: 0.125rem;
            color: #777b7e;
        }

        .cards-2 .card .list-unstyled .media-body {
            margin-left: 0.625rem;
        }

        .cards-2 .card .button-wrapper {
            position: absolute;
            right: 0;
            bottom: -1.25rem;
            left: 0;
            text-align: center;
        }

        .cards-2 .card .btn-solid-reg:hover {
            background-color: #000;
        }

        /* Best Value Label */
        .cards-2 .card .label {
            position: absolute;
            top: 0;
            right: 0;
            width: 10.625rem;
            height: 10.625rem;
            overflow: hidden;
        }

        .cards-2 .card .label .best-value {
            position: relative;
            width: 13.75rem;
            padding: 0.3125rem 0 0.3125rem 4.125rem;
            background-color: #26e38f;
            color: #fff;
            -webkit-transform: rotate(45deg) translate3d(0, 0, 0);
            -ms-transform: rotate(45deg) translate3d(0, 0, 0);
            transform: rotate(45deg) translate3d(0, 0, 0);
        }

    </style>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{asset('plugins/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/slick/slick-theme.css')}}">
@endsection

@section('content')
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-left login-left-full">
                <a href="javscript:void(0)" class="brand-logo brand-sm">
                    <img alt="" src="{{asset('images/yabee_logo_1.png')}}">
                </a>
            </div>
        </div>
    </div>
    <div class="row m-0 justify-content-center">
        <div class="col-12 p-0">
            <div class="form-area d-flex align-items-center justify-content-center h-100 text-center">
                <form class="outh-form mt-5" method="post" style="min-width: 1140px">
                    @csrf
                    <h4 class="login-title dark-one mb-2">We've prepared pricing plans for all budgets so you can get started right away. For enterprises Contact us for custom plan.</h4>

                    <div class="row">
                        <div class="col-lg-12 my-3">
                            <h4>Select Your Business Plan</h4>
                            <div class="help-block with-errors"
                                 style="color:red;">@if($errors->has('plan_id')) {{ $errors->first('plan_id') }} @endif</div>
                        </div> <!-- end of col -->
                    </div> <!-- end of row -->
                    <div class="row">
                        <div class="col-12">
                            <h4 class="login-title dark-one mt-3 mb-2 primary-text"> Currently Selected Subscription Plan: <strong class="dark-pink-text">{{$business->plan->title}}</strong></h4>
                        </div>
                    </div>
                    @include('flash::message')

                    <div class="d-flex justify-content-end">
                        <div class="d-flex justify-content-center col-xl-4 col-lg-6 col-md-6 col-sm-12 m-auto">
                            <label for="monthly_price">
                                <input class="plan_type m-2" type="radio" id="monthly_price" name="plan_type" value="1" checked/>
                                Monthly
                            </label>

                            <label for="year_price">
                                <input class="plan_type m-2" type="radio" id="year_price" name="plan_type" value="2"/>
                                Yearly
                            </label>
                        </div> <!-- end of row -->
                    </div> <!-- end of row -->

                    <div class="row cards-2 justify-content-center">
                        <?php
                            /**
                             * @var $plan \App\Models\Plan
                             * @var $business \App\Models\Business
                             */
                            ?>
                    @foreach($plans as $plan)
                        <!-- Card-->
                            <div class="col-lg-4 col-md-4">
                                <input type="hidden" data-id="{{$plan->id}}" data-type="monthly" value="{{$plan->monthly_price}}" data-stripe="{{$plan->stripe_monthly_id}}">
                                <input type="hidden" data-id="{{$plan->id}}" data-type="yearly" value="{{$plan->yearly_price}}" data-stripe="{{$plan->stripe_yearly_id}}">
                                <label class="" for="plan_value_{{ $plan->id }}">
                                    <div class=" card select-price @if(!empty(old('plan_id')) && (old('plan_id') == $plan->stripe_monthly_id || old('plan_id') == $plan->stripe_yearly_id)) active-tab @endif">
                                        <div class="card-body w-100">
                                            <div class="card-title">{{ $plan->title ?? '' }}</div>
                                            <hr class="cell-divide-hr">
                                            <div class="price primary-text">
                                                <span class="currency primary-text">$</span><span
                                                        class="value primary-text" id="plan_price_{{$plan->id}}">@if(old('plan_type') == 1 || empty(old('plan_type'))){{ $plan->monthly_price }}@else{{ $plan->yearly_price }}@endif
                                                <div class="frequency">{{ $plan->description ?? ''}}</div>
                                            </div>
                                            <hr class="cell-divide-hr">
                                            @foreach($plan->planoption()->get() as $key => $planopts )
                                                <ul class="list-unstyled li-space-lg">
                                                    <li class="media">
                                                        <span class="fa fa-check"></span>
                                                        <div class="media-body">
                                                            {{ $planopts->option_text ?? '' }}
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endforeach
                                            <div class="button-wrapper">
                                                <input type="radio" value="{{ $plan->stripe_monthly_id }}" id="plan_value_{{ $plan->id }}"
                                                       name="plan_id" style="display:none;"
                                                       @if(!empty(old('plan_id')) && (old('plan_id') == $plan->stripe_monthly_id || old('plan_id') == $plan->stripe_yearly_id)) checked @endif>
                                            </div>
                                        </div>
                                    </div> <!-- end of card -->
                                </label>
                            </div>
                            <!-- end of card -->
                        @endforeach
                    </div> <!-- end of row -->
                    <div class="mb-5 pb-5">
                        <button class="btn btn-size btn-primary">Subscribe</button>
                        <a href="{{route('general-setting-store')}}" class="btn btn-size btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('layouts.jquery')
    <script>
      jQuery(document).ready(function () {
        jQuery('.select-price').click(function (event) {
          jQuery('.active-tab').removeClass('active-tab')
          jQuery(this).addClass('active-tab')
          //event.preventDefault();
        })
      })
      function submitFormRegister () {
        $('#registerForm').submit()
      }
      $(function() {
        $('.form-control-input')
          .on('change', function() {
            $(this).removeClass('is-invalid');
            $(this).siblings('.errormsg').text('')
          })
      });

      $('.plan_type').on('change', function () {
        if (parseInt($(this).val()) === parseInt(1)) {
          $('[data-type="monthly"]').each(function () {
            $('#plan_price_'+$(this).data('id')).html($(this).val())
            $('#plan_value_'+$(this).data('id')).val($(this).data('stripe'))
          })
        }else{
          $('[data-type="yearly"]').each(function () {
            $('#plan_price_'+$(this).data('id')).html($(this).val())
            $('#plan_value_'+$(this).data('id')).val($(this).data('stripe'))
          })
        }
      })


    </script>
@endsection

@section('custom_script')
    <script>
      var $ = jQuery.noConflict();
    </script>
    <script src="{{asset('plugins/slick/slick.min.js')}}"></script>
    <script>
      $(document).ready(function(){
        $('.packages').slick({
          slidesToShow: 3,
          slidesToScroll:1,
        });
      });
    </script>
@endsection
