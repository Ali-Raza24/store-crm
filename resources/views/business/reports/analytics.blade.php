@extends('layouts.business.app')

@section('title','Analytics')

@section('header_heading', "Analytics")

@section("header_subheading", "")

@section('content')
    <div class="row">
        <div class="col-md-12 table-filter-wrap mt-5">
            <div class="col-filter">
                <div class="anlytics-filter">
                    <p class="dark-one font-weight-700 mr-3">Filter by:</p>
                    <a href="javascript:void(0)" class="btn-size btn-rounded active">Today</a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded">Weekly</a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded">Monthly</a>
                </div>
            </div>
            <div class="col-filter">
                <div class="table-misc d-flex justify-content-between">
                    <div class="date-picker">
                        <div class="form-group form-icon">
                            <input type="date" class="form-control">
                            <span>
                                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                                        </span>
                        </div>
                        <div class="form-group text-center">to</div>
                        <div class="form-group form-icon">
                            <input type="date" class="form-control">
                            <span>
                                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                                        </span>
                        </div>
                    </div>
                    <ul class="table-filter">
                        <li>
                            <div class="dropdown order-list-drop">
                                <button class="dropdown-toggle" type="button" id="dropTFilter" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <img alt="" src="{{asset('business_assets/images/filter.png')}}"> Filters
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTFilter">
                                    <div class="dropdown-box">
                                        <div class="form-group">
                                            <label class="dark-one font-weight-600">Brands</label>
                                            <div class="form-icon">
                                                <select class="form-control sm-radius-control white-border-control">
                                                    <option selected="">-- Multi Select --</option>
                                                    <option> select</option>
                                                </select>
                                                <span>
                                                                <img alt=""
                                                                     src="{{asset('business_assets/images/angledown.png')}}">
                                                            </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="dark-one font-weight-600">Categories</label>
                                            <div class="form-icon">
                                                <select class="form-control sm-radius-control white-border-control">
                                                    <option selected="">-- Multi Select --</option>
                                                    <option> select</option>
                                                </select>
                                                <span>
                                                                <img alt=""
                                                                     src="{{asset('business_assets/images/angledown.png')}}">
                                                            </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="dark-one font-weight-600">Locations</label>
                                            <div class="form-icon">
                                                <select class="form-control sm-radius-control white-border-control">
                                                    <option selected="">-- Multi Select --</option>
                                                    <option> select</option>
                                                </select>
                                                <span>
                                                                <img alt=""
                                                                     src="{{asset('business_assets/images/angledown.png')}}">
                                                            </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="drop-footer grey-one">
                                        <a href="javascript:void(0)" class="cancel-filter dark-two">
                                            Cancel</a>
                                        <a href="javascript:void(0)" class="apply-filter dark-one"> Apply
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-lg-12  mb-5 mb-sm-4">
            <div class="row chart-wrapp scroller-h">
                <div class="col-6">
                    <div class="card-repeat mt-4">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-4">
                                    <h4 class="dark-one"> Total Sales </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">AED 21,439</h3>
                                </div>
                                <div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)"> View Report </a>
                                    <h3 class="chart-percent primary-text">
                                        <span><img alt="" src="{{asset('business_assets/images/arrow-up-g.png')}}"> </span>
                                        124%
                                    </h3>
                                </div>
                            </div>
                            <div class="chart" id="chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-repeat mt-4">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-3">
                                    <h4 class="dark-one"> Total Sales </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">AED 21,439</h3>
                                </div>
                                <div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)"> View Report </a>
                                    <h3 class="chart-percent primary-text">
                                        <span><img alt="" src="{{asset('business_assets/images/arrow-up-g.png')}}"> </span>
                                        124%
                                    </h3>
                                </div>
                            </div>
                            <div class="chart" id="chart2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12  mb-5 mb-sm-4">
            <div class="row">
                <div class="col-md-8 col-sm-12 mb-4">
                    <div class="card-repeat mt-4 h-100">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-4">
                                    <h4 class="dark-one"> Total Sales </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">AED 21,439</h3>
                                </div>
                                <div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)"> View Report </a>
                                    <h3 class="chart-percent primary-text">
                                        <span><img alt="" src="{{asset('business_assets/images/arrow-up-g.png')}}"> </span>
                                        124%
                                    </h3>
                                </div>
                            </div>
                            <div class="chart" id="barchart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card-repeat mt-4 h-100">
                        <div class="chart-box">
                            <div class="chart-totals">
                                <div class="total-title mb-3">
                                    <h4 class="dark-one"> Total Sales </h4>
                                    <h3 class="chart-amaount dark-one font-weight-700">AED 21,439</h3>
                                </div>
                                <div class="chart-view mb-3">
                                    <a class="danger-text chart-report" href="javascript:void(0)"> View Report </a>
                                    <h3 class="chart-percent primary-text">
                                        <span><img alt="" src="{{asset('business_assets/images/arrow-up-g.png')}}"> </span>
                                        124%
                                    </h3>
                                </div>
                            </div>
                            <div class="chart" id="piedonut"></div>
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