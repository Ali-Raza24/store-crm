@extends('layouts.admin.app')

@section('title', 'Businesses')
@section('heading', 'Businesses')

@section('content')
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">Businesses</h2>
                <h4 class="tagline dark-one font-weight-400">Overview</h4>
            </div>
        </div>
    </div>
    <div class="row counter-wrapp scroller-h">
        <x-counter-box
                title="Total Business"
                border-color="primary"
                text-color="primary"
                total="{{$totalBusiness}}"
        ></x-counter-box>
        <x-counter-box
                title="Branches"
                border-color="lightblue"
                text-color="lightblue"
                total="{{$totalStores}}"
        ></x-counter-box>
        <x-counter-box
                title="Total Sales"
                border-color="green"
                text-color="green"
                total="0"
        ></x-counter-box>
        <x-counter-box
                title="Cancelled Orders"
                border-color="dark-pink"
                text-color="dark-pink"
                total="0"
        ></x-counter-box>
    </div>
    <div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
        <div class="col-md-12 table-filter-wrap">
            @include('admin.business.partials.navbar')
        </div>
        <hr class="m-0" />
        <h3
                class="border-heading dark-one font-weight-700 mt-lg-5 mt-4 desktop-hide"
        >
            All Businesses
            <a
                    class="btn-primary btn-rounded btn-order desktop-hide add-area-btn"
                    href="javascript:void(0)"
            >
                Add Businesses
            </a>
        </h3>
    </div>
    <hr class="mb-3 mt-0">
    <div class="tab-content" id="nav-tabContent">
        <div
                class="tab-pane fade show active"
                id="All-Business"
                role="tabpanel"
                aria-labelledby="All-Business"
        >
            @include('admin.business.partials.table')
        </div>
    </div>
    <div id="business">
        <add-business
                app_url="{{config('urls.store_url')}}"
                get_url="{{api_url('edit_business')}}"
                save_url="{{api_url('add_business')}}"
                business_type_url="{{api_url('business_types')}}"
                countries_url="{{api_url('countries')}}"
                states_url="{{api_url('states')}}"
                industries_url="{{api_url('industries')}}"
        ></add-business>
        {{--<List
                add_url="{{api_url('add_business')}}"
                get_url="{{api_url('edit_business')}}"
                business_type_url="{{api_url('business_types')}}"
                countries_url="{{api_url('countries')}}"
                states_url="{{api_url('states')}}"
                industries_url="{{api_url('industries')}}"
        ></List>--}}
    </div>
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
                        <p class="mobile-hide"><span id="totalSelected">0</span> <span class="bg-transparent" id="selectCountText">Item</span> Selected</p>

                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('admin-business-status')}}"
                       data-status="{{\App\Constants\IStatus::BUSINESS_ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Activate this business"
                       data-id="bulk"
                    >
                        <span>Active</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('admin-business-status')}}"
                       data-status="{{\App\Constants\IStatus::BUSINESS_INACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="InActive this business"
                       data-id="bulk"
                    >
                        <span>InActive</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('admin-business-bulk-delete')}}"
                       data-type="delete"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Delete this business"
                       data-id="bulk"
                    >
                        <span>Delete</span>
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
                        <input type="hidden" name="business_id" id="business_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <input type="hidden" name="plan_id" id="plan_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title Business</span>?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update this Business?</span></h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Business Right Side -->

    <!-- Modal -->
    <div class="modal fade customer-modal" id="impCsv" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">
                        Import Customers from CSV file
                    </h3>
                    <div class="form-group mt-4 mb-4 w-75 ml-auto mr-auto">
                        <div class="form-icon">
                            <input type="url" placeholder="C/:"
                                   class="form-control sm-radius-control white-border-control" />
                            <span>
                                <img alt="" src="{{asset('admin_assets/images/folder.png')}}" />
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

    <div class="body-overlay"></div>
@endsection

@section('scripts')
    <script src="{{asset_timestamp('js/business.js')}}"></script>
    <script src="{{asset('admin_assets/js/select2.min.js')}}"></script>

    <script>
        let ids = [];
        $('[data-modal="modal"]').on('click', function() {
          if ($(this).data('id') === 'bulk') {
            $.each($('.list-check:checked'), function() {
              ids.push($(this).val());
            });
            $('#business_id').val(ids);
          } else {
            $('#business_id').val($(this).data('id'));
          }
          $('#status_id').val($(this).data('status'));
          $('#plan_id').val($(this).data('plan'));
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

          if ($('.list-check:checked').length > 1){
           $('#selectCountText').text('Items')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' these businesses')
            })

          }else{
            $('#selectCountText').text('Item')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' this business')
            })
          }
        });

        $(function() {
          $('.list-check').on('change', function() {
            if ($('.list-check:checked').length === $('.list-check').length) {
              $('#checkAll').prop('checked', true);
            } else {
              $('#checkAll').prop('checked', false);
            }
            $('#totalSelected').text($('.list-check:checked').length);
            if ($('.list-check:checked').length > 1){
              $('#selectCountText').text('Items')

              $('[data-id="bulk"]').each(function() {
                let $title = $(this).data('title');
                let $titleArr = $title.split(' ');
                $(this).data('title',$titleArr[0] + ' these businesses')
              })
            }else{
              $('#selectCountText').text('Item')

              $('[data-id="bulk"]').each(function() {
                let $title = $(this).data('title');
                let $titleArr = $title.split(' ');
                $(this).data('title',$titleArr[0] + ' this business')
              })
            }
          });
        });

        function AdminLoginToBusiness(id){
          $('#AdminToBusinessLogin'+id).submit();
        }
    </script>
@endsection
