@extends('layouts.admin.app')
@section('content')
	<div class="row">
		<div class="col">
			<div class="header-lefter mobile-title desktop-hide mt-4">
				<h2 class="dark-one font-weight-700">Reports</h2>
				<h4 class="tagline dark-three font-weight-400">Quick Overview</h4>
			</div>
		</div>
	</div>
	<div class="row counter-wrapp scroller-h">
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box primary-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">Total Businesses</p>
						<h2 class="primary-text font-weight-700" data-to="546579">0</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box danger-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">Branch</p>
						<h2 class="danger-text font-weight-700" data-to="2854">0</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box success-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">Total Sales</p>
						<h2 class="success-text font-weight-700" data-to="28551">0</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mt-lg-4 mt-3">
			<div class="counter-box warning-border">
				<div class="counter-flexer">
					<div class="counter-col">
						<p class="dark-one font-weight-400">Cancelled Orders</p>
						<h2 class="warning-text font-weight-700" data-to="34654">0</h2>
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
						<a class="nav-item nav-link active" id="AllCustomer-tab" data-toggle="tab" href="#AllCustomer" role="tab" aria-controls="AllCustomer" aria-selected="true">
							All Business
						</a>
						<a class="nav-item nav-link" id="ReprtNew-tab" data-toggle="tab" href="#ReprtNew" role="tab" aria-controls="ReprtNew" aria-selected="false">
							New
						</a>
						<a class="nav-item nav-link" id="ActCustomer-tab" data-toggle="tab" href="#ActCustomer" role="tab" aria-controls="ActCustomer" aria-selected="false">
							Activated
						</a>
						<a class="nav-item nav-link" id="SuspActCustomer-tab" data-toggle="tab" href="#SuspActCustomer" role="tab" aria-controls="SuspActCustomer" aria-selected="false">
							Suspended
						</a>
						<a class="nav-item nav-link" id="ReprtPayD-tab" data-toggle="tab" href="#ReprtPayD" role="tab" aria-controls="ReprtPayD" aria-selected="false">
							Payment Due
						</a>
					</div>
				</nav>
				<div class="dropdown tabs-dropdown desktop-hide">
					<button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						All Business
					</button>
					<div class="dropdown-menu" aria-labelledby="dropTab">
						<a class="nav-item nav-link active" href="javascript:void(0)">All Business</a>
						<a class="nav-item nav-link" href="javascript:void(0)">New</a>
						<a class="nav-item nav-link" href="javascript:void(0)">Activated</a>
						<a class="nav-item nav-link" href="javascript:void(0)">Suspended</a>
						<a class="nav-item nav-link" href="javascript:void(0)">Payment Due</a>
					</div>
				</div>
			</div>
			<div class="col-filter">
				<div class="table-misc d-flex justify-content-between"></div>
				<ul class="table-filter">
					<li>
						<div class="dropdown order-list-drop">
							<button class="dropdown-toggle">
								<img alt="" src="{{asset('admin_assets/images/filter-1.png')}}"/>
								Filters
							</button>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<hr class="m-0"/>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active" id="AllCustomer" role="tabpanel" aria-labelledby="AllCustomer">
			<div class="sf-order">
				<div class="table-responsive scroll-bar-thin">
					<table class="table table-space table-check no-bor-input">
						<thead>
						<tr>
                            <th scope="col" class="custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customCheck1"/>
								<label class="custom-control-label" for="customCheck1"></label>
							</th>
							<th scope="col">Business ID</th>
							<th scope="col">Name</th>
							<th scope="col">Phone</th>
							<th scope="col">Email</th>
							<th scope="col">Plan Type</th>
							<th scope="col">Action</th>
						</tr>
						</thead>
						<tbody>
                        @for($i=0; $i < 10; $i++)
						<tr>
							<td class="custom-checkbox show-selected">
								<input type="checkbox" class="custom-control-input" id="customCheck{{$i+2}}"/>
								<label class="custom-control-label" for="customCheck{{$i+2}}"></label>
							</td>
							<td>
								<div class="table-order-no">
									<strong class="dark-one">#3515135583</strong>
									<p class="mb-0">Since: 14 Nov, 2020</p>
								</div>
							</td>
							<td><p class="mb-0 order-name dark-two">Business Name here...</p></td>
							<td><p class="mb-0 order-store dark-five">+1 458 2354 153</p></td>
							<td><p class="mb-0 darkcolor"><strong>busniess@gmail.com</strong></p></td>
							<td>
								<div class="dropdown border-dropdown">
									<button class="dropdown-toggle dark-five" type="button" id="dropReport1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Plan Type 1
									</button>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropReport1">
										<a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
										<a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
										<a class="dropdown-item" href="javascript:void(0)">Chessy Club Sandwick</a>
									</div>
								</div>
							</td>
							<td>
								<div class="table-action">
									<a href="javascript:void(0)" class="edit-order edit-area-btn">
										<img alt="" src="{{asset('admin_assets/images/edit.png')}}"/>
									</a>
									<a href="order-invoice.html" class="print-order">
										<img alt="" src="{{asset('admin_assets/images/delete-gray.png')}}"/>
									</a>
								</div>
							</td>
						</tr>
                        @endfor
						</tbody>
					</table>
				</div>
				@include('extras.pagination')
			</div>
		</div>
		<div class="tab-pane fade" id="ReprtNew" role="tabpanel" aria-labelledby="ReprtNew">2</div>
		
		<div class="tab-pane fade" id="ActCustomer" role="tabpanel" aria-labelledby="ActCustomer">3</div>
		<div class="tab-pane fade" id="SuspActCustomer" role="tabpanel" aria-labelledby="SuspActCustomer">4</div>
		<div class="tab-pane fade" id="ReprtPayD" role="tabpanel" aria-labelledby="ReprtPayD">5</div>
	</div>
@endsection

@section('footer')
	<div class="selected-item-panel">
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
	</div>
@endsection

@section('scripts')
	@include('layouts.jquery')
@endsection
