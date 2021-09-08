@extends('layouts.admin.app')

@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
	<div class="row">
		<div class="col">
			<div class="header-lefter mobile-title desktop-hide mt-4">
				<h2 class="dark-one font-weight-700">Manage Orders</h2>
				<h4 class="tagline dark-one font-weight-400">Overview</h4>
			</div>
		</div>
	</div>
	<div class="row counter-wrapp scroller-h">
		<x-counter-box border_color="primary" text_color="primary" title="All Orders" total="{{$allOrders}}" />
		<x-counter-box border_color="pending" text_color="pending" title="Pending Orders" total="{{$unfulfilledOrders}}" />
		<x-counter-box border_color="dark-pink" text_color="dark-pink" title="Unpaid" total="{{$unpaidOrders}}" />
		<x-counter-box border_color="green" text_color="green" title="Out Of Delivery" total="{{$outForDelivery}}" />
	</div>
	@include('admin.orders.navbar')
	<hr class="m-0"/>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active" id="AllOrders" role="tabpanel" aria-labelledby="AllOrders">
			@include('business.orders.partials.table')
		</div>
	</div>
@endsection

@section('footer')
	<div class="selected-item-panel">
		<div class="selected-item">
			<ul class="selected-list">
				<li>
					<div class="item-show">
                        <span>
                            <img src="{{asset('admin_assets/images/close-wgite.png')}}" alt="image" />
                        </span>
						<p class="mobile-hide"><span id="totalSelected">0</span> Items Selected</p>

					</div>
				</li>
				<li>
					<a href="javascript:void(0)" class="item-btn note-option"
					   data-url="{{route('order-bulk-status', ['type' => 'payment'])}}"
					   data-status="{{\App\Constants\IStatus::PAYMENT_PAID}}"
					   data-type="put"
					   data-toggle="modal"
					   data-modal="modal"
					   data-target="#confirmModal"
					   data-title="Paid"
					   data-id="bulk"
					>
						<span>Paid</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="item-btn import-option"
					   data-url="{{route('order-bulk-status', ['type' => 'payment'])}}"
					   data-status="{{\App\Constants\IStatus::PAYMENT_PENDING}}"
					   data-type="put"
					   data-toggle="modal"
					   data-modal="modal"
					   data-target="#confirmModal"
					   data-title="Unpaid"
					   data-id="bulk"
					>
						<span>Unpaid</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0)" class="item-btn import-option"
					   data-url="{{route('order-bulk-status', ['type' => 'order'])}}"
					   data-status="{{\App\Constants\IStatus::OUT_FOR_DELIVERY}}"
					   data-type="put"
					   data-toggle="modal"
					   data-modal="modal"
					   data-target="#confirmModal"
					   data-title="Out for Delivery"
					   data-id="bulk"
					>
						<span>Out for Delivery</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
@endsection

@section('extras')
	<div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form action="" id="confirmForm" method="post">
						@csrf
						<input type="hidden" name="_method" value="" id="method">
						<input type="hidden" name="order_id" id="order_id">
						<input type="hidden" name="status_id" id="status_id">
						<h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> Order?
						</h2>
						<h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update</span>
							this Order?</h4>
						<button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span
									data-modal-title="title">Ok</span></button>
						<a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1"
						   data-dismiss="modal">
							Cancel </a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- Import Customers Form  -->
	<div class="modal fade customer-modal" id="impCsv" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<h3 class="font-weight-700 dark-one mb-2">
						Import Customers form CSV file
					</h3>
					<div class="form-group mt-4 mb-4 w-75 ml-auto mr-auto">
						<div class="form-icon">
							<input type="url" placeholder="C/:" class="form-control sm-radius-control white-border-control"/>
							<span>
								<img alt="" src="{{asset('admin_assets/images/folder.png')}}"/>
                                </span>
						</div>
					</div>
					<h4 class="dark-two mb-3">
						Download a sample file CSV file
						<span class="dark-one font-weight-600">Click Here</span>
					</h4>
					<a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1">
						Upload
					</a>
					<a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
						Cancel
					</a>
				</div>
			</div>
		</div>
	</div>

@endsection


@section('scripts')
	@include('layouts.jquery')
	<script>

		$(function() {
			$('#state_select').select2({
				closeOnSelect: true,
				multiple: true,
				placeholder: '--Multi Select--',
				allowClear: true,
			})/*.on('select2:select', function(e) {
				var render = $(e.target).parent().find('ul.select2-selection__rendered');
				render.html(render.find('li.select2-selection__choice').filter(function(){
					return $(this).attr('title') !== '';
				}));
				$(e.target.selectedOptions).replaceWith(($(e.target.selectedOptions).filter(function()
				{
					return this.firstChild !== null;
				})));
				select.trigger('change');
			})*/
			$('#business_select').select2({
				closeOnSelect: true,
				multiple: true,
				placeholder: '--Multi Select--',
				allowClear: true,
			})/*.on('select2:select', function(e) {
				var render = $(e.target).parent().find('ul.select2-selection__rendered');
				render.html(render.find('li.select2-selection__choice').filter(function(){
					return $(this).attr('title') !== '';
				}));
				$(e.target.selectedOptions).replaceWith(($(e.target.selectedOptions).filter(function()
				{
					return this.firstChild !== null;
				})));
				select.trigger('change');
			})*/

		})

		let ids = [];
		$('[data-modal="modal"]').on('click', function() {
			if ($(this).data('id') === 'bulk') {
				$.each($('.list-check:checked'), function() {
					ids.push($(this).val());
				});
				$('#order_id').val(ids);
			} else {
				$('#order_id').val($(this).data('id'));
			}
			$('#status_id').val($(this).data('status'));
			$('[data-modal-title="title"]').text($(this).data('title'));
			$('#confirmForm').attr('action', $(this).data('url'));
			$('#method').val($(this).data('type'));
			$;
		});

		$('#checkAll').on('change', function() {
			if ($(this).is(':checked')) {
				$('.list-check').prop('checked', true);
			} else {
				$('.list-check').prop('checked', false);
			}
			$('#totalSelected').text($('.list-check:checked').length);
			console.log($('.list-check:checked').length);
		});
		$(function() {
			$('.list-check').on('change', function() {
				if ($('.list-check:checked').length === $('.list-check').length) {
					$('#checkAll').prop('checked', true);
				} else {
					$('#checkAll').prop('checked', false);
				}
				$('#totalSelected').text($('.list-check:checked').length);
			});
		});
		$(function() {
			$('.order-filter').on('change', function(){
				$(this).parent().toggleClass('selected');
			})
		})

		$(function() {
			let $fromDate = $('#from_date');
			let $toDate = $('#to_date');

			$fromDate.on('change', function() {
				if ($(this).val() !== '' && $toDate.val() !== ''){
					$('#date_filter').submit();
				}
			})

			$toDate.on('change', function() {
				if ($(this).val() !== '' && $fromDate.val() !== ''){
					$('#date_filter').submit();
				}
			})
		})
	</script>
@endsection
