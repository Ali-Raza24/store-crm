@extends('layouts.admin.app')
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
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box primary-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">
							All Customers
						</p>
						<h2 class="primary-text font-weight-700" data-to="{{$totalCustomers}}"></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box success-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">
							Total Orders
						</p>
						<h2 class="success-text font-weight-700" data-to="0">0</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box warning-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">
							Active Customers
						</p>
						<h2 class="warning-text font-weight-700" data-to="{{$activeCustomers}}"></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box danger-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">
							Suspended Customers
						</p>
						<h2 class="danger-text font-weight-700" data-to="{{$suspendedCustomers}}"></h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
		<div class="col-md-12 table-filter-wrap">
			<div class="col-filter">
				<nav class="tabs-head mobile-hide" id="allOrders">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link" id="AllCustomer-tab"  href="{{route('admin-customers-list')}}" href aria-controls="AllCustomer" aria-selected="true">
							All Customers
						</a>
						<a class="nav-item nav-link" id="ActCustomer-tab"  href="{{route('admin-customers-active-list')}}"  aria-controls="ActCustomer" aria-selected="false">
							Active
						</a>
						<a class="nav-item nav-link @if(request()->routeIs('admin-customers-suspended-list')) show active @endif" id="SuspActCustomer-tab"  href="{{route('admin-customers-suspended-list')}}"  aria-controls="SuspActCustomer" aria-selected="false">
							Suspended
						</a>
					</div>
				</nav>
				<div class="dropdown tabs-dropdown desktop-hide">
					<button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						All Customers
					</button>
					<div class="dropdown-menu" aria-labelledby="dropTab">
						<a class="nav-item nav-link active" href="javascript:void(0)">Active</a>
						<a class="nav-item nav-link" href="javascript:void(0)">Suspended</a>
					</div>
				</div>
			</div>
			<div class="col-filter">
				<div class="table-misc d-flex justify-content-between">
					<div class="date-picker">
						<div class="form-group form-icon">
							<input type="date" class="form-control"/>
							<span>
                                <img alt="" src="{{asset('admin_assets/images/calle.png')}}"/>
                            </span>
						</div>
						<div class="form-group text-center">to</div>
						<div class="form-group form-icon">
							<input type="date" class="form-control"/>
							<span>
                                <img alt="" src="{{asset('admin_assets/images/calle.png')}}" />
                            </span>
						</div>
					</div>
					<ul class="table-filter">
						<li data-toggle="modal" data-target="#impCsv">
							<img alt="" src="{{asset('admin_assets/images/download.png')}}"/>
							Import
						</li>
						<li>
							<img alt="" src="{{asset('admin_assets/images/upload.png')}}"/>
							Export
						</li>
						<li>
							<div class="dropdown order-list-drop">
								<button class="dropdown-toggle" type="button" id="dropTFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<img alt="" src="{{asset('admin_assets/images/filter.png')}}"/>
									Filters
								</button>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropTFilter">
									<div class="dropdown-box">
										<div class="form-group">
											<label class="dark-one font-weight-600">Emirates</label>
											<div class="form-icon">
												<select class="form-control sm-radius-control white-border-control">
													<option selected="">-- Multi Select --</option>
													<option>select</option>
												</select>
												<span>
                                                    <img alt="" src="{{asset('admin_assets/images/angledown.png')}}"/>
                                                </span>
											</div>
										</div>
										<div class="form-group">
											<label class="dark-one font-weight-600">Plan Type</label>
											<div class="form-icon">
												<select class="form-control sm-radius-control white-border-control">
													<option selected="">-- Multi Select --</option>
													<option>select</option>
												</select>
												<span>
                                                    <img alt="" src="{{asset('admin_assets/images/angledown.png')}}"/>
                                                </span>
											</div>
										</div>
										<div class="form-group">
											<label class="dark-one font-weight-600">Plan Type</label>
											<div class="form-icon">
												<select class="form-control sm-radius-control white-border-control">
													<option selected="">-- Multi Select --</option>
													<option>select</option>
												</select>
												<span>
                                                    <img alt="" src="{{asset('admin_assets/images/angledown.png')}}"/>
                                                </span>
											</div>
										</div>
									</div>
									<div class="drop-footer grey-one">
										<a href="javascript:void(0)" class="cancel-filter dark-two">Cancel</a>
                                        <a href="javascript:void(0)" class="apply-filter dark-one">Apply</a>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<hr class="m-0"/>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade" id="AllCustomer" role="tabpanel" aria-labelledby="AllCustomer">

		</div>
		<div class="tab-pane fade" id="ActCustomer" role="tabpanel" aria-labelledby="ActCustomer">

        </div>

		<div class="tab-pane fade @if(request()->routeIs('admin-customers-suspended-list')) show active @endif" id="SuspActCustomer" role="tabpanel" aria-labelledby="SuspActCustomer">
            @include('admin.customers.partials.table')
        </div>
	</div>
@endsection
@section('footer')
	<!--<div class="selected-item-panel">
		<div class="selected-item">
			<ul class="selected-list">
				<li>
					<div class="item-show">
                        <span>
                            <img src="{{asset('admin_assets/images/close-wgite.png')}}" alt="image"/>
                        </span>
						<p class="mobile-hide">2 Items Selected</p>
					</div>
				</li>
				<li>
					<a href="javascript:void(0)" class="item-btn note-option mobile-hide">
						<img src="{{asset('admin_assets/images/writing-white.png')}}" alt="image"/>
						<span>Note</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="item-btn import-option">
						<span>Import</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="item-btn export-option">
						<span>Export</span>
					</a>
				</li>
			</ul>
		</div>
	</div>-->

@endsection
@include('admin.customers.partials.extra')
