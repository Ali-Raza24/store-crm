@extends('layouts.admin.app')

@section('title', 'Pages')
@section('heading', 'Pages')

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
				<nav class="tabs-head mobile-hide" id="allOrders">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="Pages-tab" data-toggle="tab" href="#Pages" role="tab" aria-controls="Pages" aria-selected="true">
							Pages
						</a>
						<a class="nav-item nav-link" id="In-Active-tab" data-toggle="tab" href="#In-Active" role="tab" aria-controls="In-Active" aria-selected="false">
							In Active
						</a>
					</div>
				</nav>
				<div class="dropdown tabs-dropdown desktop-hide">
					<button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Pages
					</button>
					<div class="dropdown-menu" aria-labelledby="dropTab">
						<a class="nav-item nav-link active" href="javascript:void(0)">In Active</a>
					</div>
				</div>
				<hr class="m-0"/>
				<div class="tab-content mt-5" id="nav-settingContent">
					<div class="tab-pane fade pro-table-seting show active" id="Pages" role="tabpanel">
						<div class="d-flex justify-content-between align-items-center">
							<h4 class="font-weight-700 dark-one">All Pages</h4>
						</div>
						<div class="table-responsive scroll-bar-thin">
							<table class="table table-space">
								<thead>
								<tr>
									<th scope="col">Name</th>
									<th scope="col">Meta Description</th>
									<th scope="col">Status</th>
									<th scope="col">Actions</th>
								</tr>
								</thead>
								<tbody>
                                @for($i=0; $i<5; $i++)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div class="table-order-no">
												<strong class="dark-one">
                                                    <a href="#">John Smith</a>
                                                </strong>
												<p class="mb-0">Dec 02, 2020</p>
											</div>
										</div>
									</td>
									<td>
										<p class="mb-0 order-name">Lorem ipsum dolor sit amet,<br/>consectetur adipiscing</p>
									</td>
									<td>
										<div class="dropdown">
                                            <span class="dropdown-toggle" id="dropStore1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Active
                                            </span>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropStore1">
												<a class="dropdown-item" href="javascript:void(0)">
													active
												</a>
												<a class="dropdown-item" href="javascript:void(0)">
													Unactive
												</a>
											</div>
										</div>
									</td>
									<td>
										<div class="table-action">
											<a href="#" class="edit-order mr-3">
												<img alt="" src="{{asset('admin_assets/images/edit1.png')}}"/>
											</a>
										</div>
									</td>
								</tr>
                                @endfor
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-md-6">
								<p class="dark-one m-3">Showing 5 of 30 records</p>
							</div>
							<div class="col-md-6">
								@include('extras.pagination')
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="In-Active" role="tabpanel" aria-labelledby="settStore">
						<form>
							<div class="row">
								<div class="col-sm-6 form-group mb-3">
									<label class="font-weight-600 dark-one mb-2">Name</label>
									<input type="text" placeholder="" class="form-control order-edit-control"/>
								</div>
								<div class="col-sm-6 form-group mb-3">
									<label class="font-weight-600 dark-one mb-2">Title</label>
									<input type="text" placeholder="" class="form-control order-edit-control"/>
								</div>
								<div class="col-md-12 form-group mb-3">
									<label class="font-weight-600 dark-one">Meta Descripation</label>
									<textarea placeholder="" class="form-control order-edit-control"></textarea>
								</div>
								<div class="col-sm-6 form-group mb-3">
									<label class="font-weight-600 dark-one">Heading</label>
									<input type="text" placeholder="John Smith " class="form-control order-edit-control"/>
								</div>
								<div class="col-sm-6 form-group mb-3">
									<label class="font-weight-600 dark-one mb-2">Link</label>
									<input type="text" placeholder="Johnsmith@gmail.com" class="form-control order-edit-control"/>
								</div>

								<div class="col-md-12 form-group mb-3">
									<label class="font-weight-600 dark-one mb-2">Content</label>
									<div class="content-editor">
										<img src="{{asset('admin_assets/images/content-editor.png')}}" alt="image"/>
									</div>
								</div>
							</div>
						</form>

						<div class="form-group mb-0 text-right">
							<hr class="mt-5 mb-3"/>
							<a href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3">
								Update
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('extras')
	<!-- Add New Testimonial -->
	<div class="modal fade customer-modal" id="addNewTestimonials" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h3 class="font-weight-700 dark-one mb-2">
						Add Testimonial
					</h3>
					<div class="mt-4 mb-4 w-75 ml-auto mr-auto">
						<div class="form-group">
                                <span class="add-brand">
                                    <img alt="" src="{{asset('admin_assets/images/customer-placeholder.png')}}"/>
                                </span>
						</div>
						<div class="form-group text-left">
							<label class="font-weight-600 dark-one mb-2">Name</label>
							<input type="text" class="form-control sm-radius-control white-border-control"/>
						</div>
						<div class="form-group text-left">
							<label class="font-weight-600 dark-one mb-2">Message</label>
							<textarea class="form-control sm-radius-control white-border-control"></textarea>
						</div>
						<div class="form-group text-left">
							<label class="font-weight-600 dark-one mb-2">Status</label>
							<div class="form-icon">
								<select class="form-control sm-radius-control white-border-control">
									<option>-- Select --</option>
									<option>Select</option>
								</select>
								<span>
                                    <img alt="" src="{{asset('admin_assets/images/angledown.png')}}"/>
                                </span>
							</div>
						</div>
					</div>
					<a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
						Cancel
					</a>
					<a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1">
						Add
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Emirates -->
	<div class="modal fade customer-modal" id="addNewEmirates" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h3 class="font-weight-700 dark-one mb-2">
						Add Emirates
					</h3>
					<div class="mt-4 mb-4 w-75 ml-auto mr-auto">
						<div class="form-group">
                                <span class="add-brand">
                                    <img alt="" src="{{asset('admin_assets/images/customer-placeholder.png')}}"/>
                                </span>
						</div>
						<div class="form-group text-left">
							<label class="font-weight-600 dark-one mb-2">Name</label>
							<input type="text" class="form-control sm-radius-control white-border-control"/>
						</div>
						<div class="form-group text-left">
							<label class="font-weight-600 dark-one mb-2">Status</label>
							<div class="form-icon">
								<select class="form-control sm-radius-control white-border-control">
									<option>-- Select --</option>
									<option>Select</option>
								</select>
								<span>
                                    <img alt="" src="{{asset('admin_assets/images/angledown.png')}}"/>
                                    </span>
							</div>
						</div>
					</div>
					<a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
						Cancel
					</a>
					<a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1">
						Add
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection


@section('scripts')
	@include('layouts.jquery')
@endsection
