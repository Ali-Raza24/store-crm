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
                    <div class="tab-pane fade show active" id="settPayment" role="tabpanel"
                         aria-labelledby="settPayment">
                        <div class="row">
                            <div class="col-12">
                                <form action="">
                                    <div class="payment-activer sm-radius-control mb-5">
                                        <div class="colr">
                                            <span class="darkcolor font-weight-600">Yabee </span>
                                        </div>
                                        <div class="colr">
                                            <span class="darkcolor font-weight-500">Currently payments are accepted with Yabee</span>
                                        </div>
                                        <div class="colr">
                                            <div class="on-off-toggle">
                                                <input class="on-off-toggle__input" type="checkbox" id="bopis" />
                                                <label for="bopis" class="on-off-toggle__slider"></label>
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div class="alert alert-info">
                                        Currently payments are accepted with oogo pay.
                                    </div>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
@endsection
