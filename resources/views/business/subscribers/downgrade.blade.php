<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('business_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/customer.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/style.css')}}">
    <title>{{config('app.name')}} | Business Dashboard</title>
</head>

<body>

<main class="wrapper grey-one">
    <header class="web-header">
        <div class="container-fluid">
            <div class="mobile-header">
                <a href="{{route('upgrade-subscription')}}" class="d-inline-block">
                    <h4 class="font-weight-700 dark-one">
                        <img src="{{asset('business_assets/images/arrow-back.png')}}" alt="" class="mr-1"> Back
                    </h4>
                </a>
            </div>
            <div class="header-flexer">
                <div class="mobile-hide w-100">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="header-lefter">
                                <a href="{{route('upgrade-subscription')}}" class="d-inline-block">
                                    <h4 class="font-weight-700 dark-one">
                                        <img src="{{asset('business_assets/images/arrow-back.png')}}" alt=""
                                             class="mr-1"> Back
                                    </h4>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-4 text-center">
                            <h3 class="dark-one font-weight-700">
                                {{$business->plan->title}} <span
                                        class="primary-text">$ {{$business->plan->monthly_price}}</span>
                            </h3>
                            <span class="primary-text">This is your current plan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section id="main-body" class="grey-one">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-lefter mobile-title desktop-hide text-center mt-4 mb-4">
                        <h2 class="dark-one font-weight-700 text-center">
                            {{$business->plan->title}}
                            <span class="primary-text">$ {{$business->plan->monthly_price}}</span>
                        </h2>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    @if($business->plan->monthly_price > $plan->monthly_price)
                        <h2 class="dark-one font-weight-700 text-center mt-5 mobile-hide">Change Plan</h2>
                    @else
                        <h2 class="dark-one font-weight-700 text-center mt-5 mobile-hide">Change Plan</h2>
                    @endif
                    <div class="pricing-select card-repeat">
                        @if(!empty($staff) && $staff == true)
                            <div class="form-group ml-4 mr-4">
                                <h3 class="dark-one font-weight-700 mb-2">Staff</h3>
                                <p class="danger-text mb-5">You are going to lose your staff...</p>
                            </div>
                            <div class="form-group ml-4 mr-4">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="{{route('user-list')}}" target="_blank"
                                           class="btn-primary btn-rounded btn-size">
                                            <h4 class="font-weight-700 dark-one">
                                                Go to Staff list
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-4 mb-4">
                        @endif
                        @if(!empty($store) && $store == true)
                            <div class="form-group ml-4 mr-4">
                                <h3 class="dark-one font-weight-700 mb-2 mt-3">Stores</h3>
                                <p class="danger-text mb-5">You are going to lose your Stores...</p>
                            </div>
                            <div class="form-group ml-4 mr-4">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="{{route('general-setting-store')}}" target="_blank"
                                           class="btn-primary btn-rounded btn-size">
                                            <h4 class="font-weight-700 dark-one">
                                                Go to Store list
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-4 mb-4">
                        @endif
                        @if(!empty($product) && $product == true)
                            <div class="form-group ml-4 mr-4">
                                <h3 class="dark-one font-weight-700 mb-2 mt-3">Products</h3>
                                <p class="danger-text mb-5">You are going to lose your Products...</p>
                            </div>
                            <div class="form-group ml-4 mr-4">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="{{route('products-list')}}" target="_blank"
                                           class="btn-primary btn-rounded btn-size">
                                            <h4 class="font-weight-700 dark-one">
                                                Go to Products list
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="javascript:void(0)"
                   class="btn-size btn-rounded btn-primary btn-pricing font-weight-normal mt-4" data-toggle="modal"
                   data-target="#changePlan">
                    Change Plan
                </a>
            </div>
        </div>
    </section>

    <footer class="web-footer">
        <p class="mb-0">Copyrights &copy; {{\Carbon\Carbon::now()->year}} All Rights Reserved by <span
                    class="primary-text">{{config('app.name')}}</span></p>
    </footer>

</main>

<!-- Change Plan -->
<div class="modal fade customer-modal" id="changePlan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {!! Form::open(['route' => 'upgrade-subscription']) !!}
                @if($planType == 1)
                {!! Form::hidden('plan_id', $plan->stripe_monthly_id) !!}
                @else
                    {!! Form::hidden('plan_id', $plan->stripe_yearly_id) !!}
                @endif
                {!! Form::hidden('plan_type', $planType) !!}
                <h3 class="font-weight-700 dark-one mb-2">Are You Sure?</h3>
                <h5 class="dark-one font-weight-400 mb-5">Are You sure to change this plan?</h5>
                <button class="btn-size btn-rounded btn-primary ml-1 mr-1 mb-1"> YES </button>
                <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1 mb-1" data-dismiss="modal">
                    NO
                </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@include('layouts.jquery')
@include('layouts.business.scripts')

</body>

</html>
