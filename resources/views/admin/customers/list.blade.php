@extends('layouts.admin.app')

@section('title', 'Customers')
@section('heading', 'Customers')

@section('content')
	<div class="row">
		<div class="col">
			<div class="header-lefter mobile-title desktop-hide mt-4">
				<h2 class="dark-one font-weight-700">
					Total Customers
				</h2>
				<h4 class="tagline dark-one font-weight-400">
					Overview
				</h4>
			</div>
		</div>
	</div>
    @include('flash::message')
    <div class="row counter-wrapp scroller-h">
		<x-counter-box column="3" border_color="primary" text_color="primary" title="All Customers"
					   total="{{$allCustomersCount}}"
					   class="mt-lg-4 mt-3" />
		<x-counter-box column="3" border_color="green" text_color="green" title="Total Orders"
					   total="{{$ordersCount}}"
					   class="mt-lg-4 mt-3" />
		<x-counter-box column="3" border_color="lightblue" text_color="lightblue" title="Active Customers"
					   total="{{$activeCustomersCount}}"
					   class="mt-lg-4 mt-3" />
		<x-counter-box column="3" border_color="dark-pink" text_color="dark-pink" title="Suspended Customers"
					   total="{{$suspendedCustomersCount}}"
					   class="mt-lg-4 mt-3" />
    </div>
	<div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
		<div class="col-md-12 table-filter-wrap">
			<div class="col-filter">
				<nav class="tabs-head mobile-hide" id="allOrders">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link @if(request()->routeIs('admin-customers-list')) active @endif"  href="{{route('admin-customers-list')}}">
							All Customers
						</a>
						<a class="nav-item nav-link @if(request()->routeIs('admin-customers-active-list')) active @endif" href="{{route('admin-customers-active-list')}}">
							Active
						</a>
						<a class="nav-item nav-link @if(request()->routeIs('admin-customers-suspended-list')) active @endif" href="{{route('admin-customers-suspended-list')}}">
							Suspended
						</a>
					</div>
				</nav>
				<div class="dropdown tabs-dropdown desktop-hide">
					<button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						All Customers
					</button>
					<div class="dropdown-menu" aria-labelledby="dropTab">
						<a class="nav-item nav-link @if(request()->routeIs('admin-customers-list')) active @endif" href="{!! route('admin-customers-list') !!}">All Customers</a>
						<a class="nav-item nav-link @if(request()->routeIs('admin-customers-active-list')) active @endif" href="{!! route('admin-customers-active-list') !!}">Active Customers</a>
						<a class="nav-item nav-link @if(request()->routeIs('admin-customers-suspended-list')) active @endif" href="{!! route('admin-customers-suspended-list') !!}">Suspended Customers</a>
					</div>
				</div>
			</div>
			<div class="col-filter">
				<div class="table-misc d-flex justify-content-between">
					<ul class="table-filter">
						{{--<li data-toggle="modal" data-target="#impCsv">
							<img alt="" src="{{asset('admin_assets/images/download.png')}}"/>
							Import
						</li>
						<li>
							<img alt="" src="{{asset('admin_assets/images/upload.png')}}"/>
							Export
						</li>--}}
						<li>
							<form>
							<div class="dropdown order-list-drop">
								<button class="dropdown-toggle" type="button" id="dropTFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<img alt="" src="{{asset('admin_assets/images/filter.png')}}"/>
									Filters
								</button>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTFilter">
									<div class="dropdown-box">
										<div class="form-group">
											<label class="dark-one font-weight-600">City</label>
											{!! Form::select('state[]', \App\Helpers\CommonHelper::states(), request()->get('state'), ['class' =>'js-select2 order-edit-control form-control', 'multiple']) !!}
										</div>
										<div class="form-group">
											<div class="mb-3">
												<p class="dark-one font-weight-600">
													Business Registration
												</p>
												@php
													use Carbon\Carbon;
                                                    if (empty(request()->get('from_date'))) {
                                                        $startDate = Carbon::now()->format('m/d/Y');
                                                    } else {
                                                        $startDate = Carbon::createFromFormat('Y-m-d', request()->get('from_date'))->format('m/d/Y');
                                                    }
                                                    if (empty(request()->get('to_date'))){
                                                        $toDate = Carbon::now()->format('Y/m/d');
                                                    } else {
                                                        $toDate = Carbon::createFromFormat('Y-m-d', request()->get('to_date'))->format('m/d/Y');
                                                    }
												@endphp
												<div class="date-picker">
													<div class="form-group form-icon">
														<input name="from_date" type="date" class="form-control" value="{{$startDate}}" />
														<span><img alt="" src="{{asset('admin_assets/images/calle.png')}}" /></span>
													</div>
													<div class="form-group text-center">to</div>
													<div class="form-group form-icon">
														<input name="to_date" type="date" class="form-control" value="{{$toDate}}" />
														<span>
                                                <img alt="" src="{{asset('admin_assets/images/calle.png')}}" />
                                            </span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="drop-footer grey-one d-flex justify-content-between">
										<button class="apply-filter dark-one">Apply</button>
										<button class="cancel-filter dark-two" type="button" data-toggle="dropdown">Cancel</button>
										<a href="{{url()->current()}}" class="apply-filter dark-one">Clear</a>
									</div>
								</div>
							</div>
							</form>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<hr class="m-0"/>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active">
            @include('admin.customers.partials.table')
		</div>
	</div>
@endsection
@include('admin.customers.partials.extra')
