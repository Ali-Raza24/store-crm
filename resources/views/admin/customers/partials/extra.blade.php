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
@section('extras')
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
                       data-url="{{route('admin-customers-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::BUSINESS_ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Active"
                       data-id="bulk"
                    >
                        <span>Active</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('admin-customers-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::BUSINESS_SUSPENDED}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Suspended"
                       data-id="bulk"
                    >
                        <span>Suspended</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title</span> Customer?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update</span> this Customer?</h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
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
        $.ajaxSetup({
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        })

        // order payment status change
        function orderPaymentStatusChange(order_id, status_id) {
            $('.dropdown-toggle').dropdown('hide');
            if (order_id != '' && status_id != '') {
                $.ajax({
                    url: '',
                    type: 'GET',
                    dataType: 'json',
                    data: { order_id: order_id, status_id: status_id },
                    success: function (data) {
                        $('#dropdown-text-'+order_id).text(data)
                    }
                })
            } else {alert('Error!, Order id not found.')}
        }
        // order  status change
        function orderFulfillmentStatusChange(order_id, status_id) {
            $('.dropdown-toggle').dropdown('hide');
            if (order_id != '' && status_id != '') {
                $.ajax({
                    url: '',
                    type: 'GET',
                    dataType: 'json',
                    data: { order_id: order_id, status_id: status_id },
                    success: function (data) {
                        $('#dropdown-textorder-'+order_id).text(data)
                    }
                })
            } else {alert('Error!, Order id not found.')}
        }




        let ids = [];
        $('[data-modal="modal"]').on('click', function(){
            if ($(this).data('id') === 'bulk'){
                $.each($('.list-check:checked'), function(){
                    ids.push($(this).val())
                })
                $('#customer_id').val(ids)
            } else {
                $('#customer_id').val($(this).data('id'));
            }
            $('#status_id').val($(this).data('status'));
            $('[data-modal-title="title"]').text($(this).data('title'))
            $('#confirmForm').attr('action',$(this).data('url'))
            $('#method').val($(this).data('type'))
            $
        });

        $('#checkAll').on('change',function(){
            if ($(this).is(':checked')){
                $('.list-check').prop('checked', true)
            }else{
                $('.list-check').prop('checked', false)
            }
            $('#totalSelected').text($('.list-check:checked').length)
            console.log($('.list-check:checked').length);
        })
        $(function(){
            $('.list-check').on('change', function(){
                if($('.list-check:checked').length === $('.list-check').length){
                    $('#checkAll').prop('checked', true)
                }else{
                    $('#checkAll').prop('checked', false)
                }
                $('#totalSelected').text($('.list-check:checked').length)
            })
        })
    </script>
@endsection
