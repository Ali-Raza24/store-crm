@extends('layouts.admin.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.26.3/dist/apexcharts.css">

    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">
                    Dashboard
                </h2>
                <h4 class="tagline dark-one font-weight-400">
                    Quick Overview
                </h4>
            </div>
        </div>
    </div>
    <div class="row counter-wrapp scroller-h">
        <x-counter-box column="3" border_color="primary" text_color="primary" title="Total Business"
                       icon="order2.png"
                       total="{{$businessTotalCount}}" />
        <x-counter-box column="3" border_color="green" text_color="green" title="Branches"
                       icon="payment2.png"
                       total="{{$storesTotalCount}}" />
        <x-counter-box column="3" border_color="lightblue" text_color="lightblue" title="Total Sales"
                       icon="payment2.png"
                       total="{{$totalSales}}" />
        <x-counter-box column="3" border_color="dark-pink" text_color="dark-pink" title="Cancelled Orders"
                       icon="product2.png"
                       total="{{$cancelledOrders}}" />
    </div>
    <div class="row">
        <div class="col-xl-9 col-md-8">
            <h3 class="border-heading dark-one font-weight-700 mt-lg-5 mt-4">
                Report
            </h3>
            <div class="card-repeat mt-4 total-business">
                <div class="chart-box">
                    <div class="chart-totals">
                        <div class="total-title mb-4">
                            <h4 class="dark-one">
                                Total Businesses
                            </h4>
                            <h3 class="chart-amaount dark-one font-weight-700">
                                {!! $businessTotalCount !!}
                            </h3>
                        </div>
                        {{--<div class="chart-view mb-3">
                            <a class="danger-text chart-report" href="javascript:void(0)">
                                View Report
                            </a>
                            <h3 class="chart-percent primary-text">
                                <span>
                                    <img alt="" src="{{asset('admin/images/arrow-up-g.png')}}"/>
                                </span>
                                124%
                            </h3>
                        </div>--}}
                    </div>
                    <div class="chart">
                        {!! $businessChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 order--sm-last">
            <div class="sf-activities">
                <h3 class="border-heading dark-one font-weight-700 mt-lg-5 mt-4">
                    Recent Activities
                </h3>
                <div class="activity-panel card-repeat scroll-bar-thin mt-4">
                    @foreach($recentActivities as $activity)
                        <div class="media">
                            <span class="mr-2 activity-icon"></span>
                            <div class="media-body">
                                <p class="mb-0">{!! $activity->description !!} #{!! $activity->subject_id !!}</p>
                                <small class="dark-four">by <b>{!! optional($activity->user)->name !!}</b> - {!! \Carbon\Carbon::parse($activity->created_at)->format('d M, Y H:i a') !!}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-5 mb-sm-4">
            <div class="row chart-wrapp scroller-h">
                <div class="col-6">
                    <div class="card-repeat mt-4">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-4">
                                    <h4 class="dark-one">
                                        Total Branches
                                    </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">{{$storesTotalCount}}</h3>
                                </div>
                                {{--<div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)">
                                        View Report
                                    </a>
                                    <h3 class="chart-percent primary-text">
                                        <span>
                                            <img alt="" src="{{asset('admin/images/arrow-up-g.png')}}"/>
                                        </span>
                                        124%
                                    </h3>
                                </div>--}}
                            </div>
                            <div class="chart">
                                {!! $storeChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-repeat mt-4">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-3">
                                    <h4 class="dark-one">
                                        Total Sales
                                    </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">
                                        AED {!! $totalSales !!}
                                    </h3>
                                </div>
                                {{--<div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)">
                                        View Report
                                    </a>
                                    <h3 class="chart-percent primary-text">
                                        <span>
                                            <img alt="" src="{{asset('admin/images/arrow-up-g.png')}}"/>
                                        </span>
                                        124%
                                    </h3>
                                </div>--}}
                            </div>
                            <div class="chart">
                                {!! $salesChart->container() !!}
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
{{--    <script src="{{ $businessChart->cdn() }}"></script>--}}
@endsection

@section('custom_script')
    {{ $businessChart->script() }}
    {{ $storeChart->script() }}
    {{ $salesChart->script() }}
@endsection
