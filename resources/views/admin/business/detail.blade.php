@extends('layouts.admin.app')
@section('content')
    {{--<div id="business">
        <edit-business
                save_url="{{api_url('add_business')}}"
                get_url="{{api_url('edit_business')}}"
        ></edit-business>
    </div>--}}
    {!! Form::open(['url' => route('admin-business-update')]) !!}
    {{method_field('PUT')}}
    {!! Form::hidden('business_id',$business->id) !!}
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide text-center mt-4">
                <h2 class="dark-one font-weight-700 text-center">
                    Agree to Subscribe
                </h2>
            </div>
        </div>
    </div>
    <div class="location-update pt-4">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="custom-checkbox">
                    <input
                            type="checkbox"
                            class="custom-control-input"
                            id="customCheck1"
                    />
                    <label
                            class="custom-control-label w-100 h-100 pl-4"
                            for="customCheck1"
                    >
                        <span class="pl-2">Agree to Subscribe</span>
                    </label>
                </div>
            </div>
            <div class="col-6 pl-0">
                <div class="text-right">
                    <a href="{{route('admin-business-edit', $business->id)}}" class="btn-size btn-rounded btn-primary">
                        Edit Business
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row counter-wrapp scroller-h mb-4">
        <x-counter-box
                title="Branches"
                border-color="primary"
                text-color="primary"
                total="{{$totalStores}}"
                extra-class="mt-lg-4 mt-3"
        ></x-counter-box>
        <x-counter-box
                title="Total Sales"
                border-color="primary"
                text-color="primary"
                total="0"
                extra-class="mt-lg-4 mt-3"
        >
        </x-counter-box>
        <x-counter-box
                title="Number of Products"
                border-color="success"
                text-color="success"
                total="{{$totalProducts}}"
                extra-class="mt-lg-4 mt-3"
        ></x-counter-box>
        <x-counter-box
                title="Paid Invoice"
                border-color="danger"
                text-color="danger"
                total="0"
                extra-class="mt-lg-4 mt-3"
        ></x-counter-box>
    </div>
    @php
        /**
        * @var $business \App\Models\Business
        **/
    @endphp
    <div class="customer-panel">
        <div class="row align-items-center">
            <div class="col-md-4 col-sm-12 text-center">
                <div class="customer-img-panel" id="image">
                    <div class="basic-customer">
                        <span>
                            @if(!empty($business->logo))
                                <image-upload name="images[]" image_placeholder="{{$business->logo}}"></image-upload>
                            @else
                                <image-upload name="images[]" image_placeholder="{{asset('img/camera_icon.png')}}"></image-upload>
                            @endif
                        </span>
                        <p>{{ $business->plan_name }}</p>
                    </div>
                    <h3 class="dark-one font-weight-700 mt-3">
                        {{ $business->name }}
                    </h3>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 b-l">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Admin Name</h6>
                            <p>{{ $business->owner_name }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Admin Email</h6>
                            <p>{{ $business->owner_email }}</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">Admin Mobile</h6>
                            <p>{{ $business->owner_mobile }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">
                                Business Name
                            </h6>
                            <p>{{ $business->name }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">
                                Email
                            </h6>
                            <p>{{ $business->email }}</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">
                                Phone
                            </h6>
                            <p>{{ $business->phone }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">
                                Address
                            </h6>
                            <p>{{ $business->address_1 }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">
                                Brand Color
                            </h6>
                            <div style="width: 50px; height: 30px; background-color: {{$business->brand_color}}"
                            ></div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-3 col-sm-3">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">
                                Business Type
                            </h6>
                            <p>{{optional($business->businessType)->title}}</p>
                        </div>
                    </div>
                    {{--<div class="col-md-12">
                        <div class="customer-detail-panel">
                            <h6 class="dark-one">KYC Detail</h6>
                            <div class="form-group mt-1">
                <textarea
                        placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi."
                        class="order-edit-control form-control"
                ></textarea>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="row mt-5">
        <div class="col-md-12 table-filter-wrap">
            <div class="col-filter">
                <nav class="tabs-head mobile-hide" id="allOrders">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a
                                class="nav-item nav-link @if(request()->routeIs('admin-business-detail-staff') || request()->routeIs('admin-business-detail')) active @endif"
                                id="Staff-Accounts-tab"
                                href="{{route('admin-business-detail-staff', $business->id)}}"
                                role="tab"
                                aria-selected="true"
                        >Staff Accounts</a
                        >
                        <a
                                class="nav-item nav-link @if(request()->routeIs('admin-business-detail-transactions')) active @endif"
                                id="Transaction-History-tab"
                                href="{{route('admin-business-detail-transactions', $business->id)}}"
                                role="tab"
                                aria-selected="true"
                        >Transaction History</a
                        >
                    </div>
                </nav>
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button
                            class="dropdown-toggle"
                            type="button"
                            id="dropTab"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                    >
                        Staff Accounts
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link active" href="{{route('admin-business-detail-staff', $business->id)}}"
                        >Staff Accounts</a
                        >
                        <a class="nav-item nav-link" href="{{route('admin-business-detail-transactions', $business->id)}}"
                        >Transaction History</a
                        >
                    </div>
                </div>
            </div>
            <div class="col-filter">
                <div class="table-misc d-flex justify-content-between">
                    @if(request()->routeIs('admin-business-detail-transactions'))
                        {{--<div class="form-group form-icon all-transection mb-0 mobile-hide">
                            <select class="form-control">
                                <option>All Transacions</option>
                                <option>All Transacions</option>
                                <option>All Transacions</option>
                            </select>
                            <span>
                    <img alt="" src="{{asset('admin_assets/images/angledown1.png')}}" />
                  </span>--}}
                </div>
                @endif
                <form id="date_filter">
                    <div class="date-picker">
                        <div class="form-group form-icon">
                            <input name="from_date" type="date" class="form-control" id="from_date">
                            <span>
                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                        </span>
                        </div>
                        <div class="form-group text-center">to</div>
                        <div class="form-group form-icon">
                            <input name="to_date" type="date" class="form-control" id="to_date">
                            <span>
                            <img alt="" src="{{asset('business_assets/images/calle.png')}}">
                        </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <hr class="m-0" />
    <div class="tab-content" id="nav-tabContent">
        @if(request()->routeIs('admin-business-detail-staff') || request()->routeIs('admin-business-detail'))
            <div
                    class="tab-pane fade show active"
                    id="Staff-Accounts"
                    role="tabpanel"
                    aria-labelledby="Staff-Accounts"
            >
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive scroll-bar-thin">
                            <table class="table table-space table-check bor-input.table">
                                <thead>
                                <tr>
                                    <th scope="col" class="custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkAll" />
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </th>
                                    <th scope="col">Account Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($staffs as $staff)
                                    <tr>
                                        <td class="custom-checkbox show-selected">
                                            <input type="checkbox" class="custom-control-input list-check" value="{{$staff->id}}" name="ids[]" id="customCheck{{$loop->iteration +2}}" />
                                            <label class="custom-control-label" for="customCheck{{$loop->iteration +2}}"></label>
                                        </td>
                                        <td>
                                            <div class="table-order-no">
                                                <strong class="dark-one">
                                                    <a href="#">{{$staff->name}}</a>
                                                </strong>
                                                <p class="mb-0">

                                                </p>
                                            </div>
                                        </td>
                                        <td><p class="mb-0 order-name">Staff</p></td>
                                        <td>
                                            <p class="mb-0 order-total">{{$staff->phone}}</p>
                                            <p class="mb-0 order-total">{{$staff->email}}</p>
                                        </td>
                                        <td><p class="mb-0 order-name">{{\App\Helpers\CommonHelper::getStatus($staff->is_active)}}</p></td>
                                        <td>
                                            <div class="w-100">
                                                @if($staff->is_active == \App\Constants\IStatus::ACTIVE)
                                                    <a href="" class="btn-size btn-rounded btn-light danger-text"
                                                       data-url="{{route('suspend-user')}}"
                                                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                                                       data-type="put"
                                                       data-toggle="modal"
                                                       data-modal="modal"
                                                       data-target="#confirmModal"
                                                       data-title="Suspend user"
                                                       data-id="{{$staff->id}}"
                                                    >Suspend User</a>
                                                @else
                                                    <a href="" class="btn-size btn-rounded btn-light danger-text"
                                                       data-url="{{route('suspend-user')}}"
                                                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                                       data-type="put"
                                                       data-toggle="modal"
                                                       data-modal="modal"
                                                       data-target="#confirmModal"
                                                       data-title="Suspend user"
                                                       data-id="{{$staff->id}}"
                                                    >Active User</a>
                                                @endif
                                            </div>
                                        </td>
                                        {{--<td>
                                            <div class="table-action">
                                                <a href="javascript:void(0)" class="edit-order">
                                                    <img alt="" src="{{asset('admin_assets/images/edit.png')}}" />
                                                </a>
                                                <a href="javascript:void(0)" class="print-order">
                                                    <img src="{{asset('admin_assets/images/delete-gray.png')}}" alt="" />
                                                </a>
                                            </div>
                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @php $paginator = $staffs->toArray() @endphp
                        <div class="d-flex justify-content-between">
                            <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
                            {!! $staffs->appends(request()->getQueryString())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(request()->routeIs('admin-business-transactions'))
            <div
                    class="tab-pane fade show active"
                    id="Transaction-History"
                    role="tabpanel"
                    aria-labelledby="Transaction-History"
            >
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive scroll-bar-thin">
                            <table class="table table-space table-check">
                                <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Ref ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('extras')
    <!-- Modal -->
    <div class="selected-item-panel">
        <div class="selected-item">
            <ul class="selected-list">
                <li>
                    <div class="item-show">
                        <span>
                            <img src="{{asset('business_assets/images/close-wgite.png')}}" alt="image" />
                        </span>
                        <p class="mobile-hide"><span id="totalSelected">0</span> <span class="bg-transparent" id="selectCountText">Item</span> Selected</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('suspend-user')}}"
                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Suspend user"
                       data-id="bulk"
                    >
                        <span>Suspend</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('suspend-user')}}"
                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Active staff"
                       data-id="bulk"
                    >
                        <span>Active</span>
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
                        <input type="hidden" name="staff_id" id="staff_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <input type="hidden" name="plan_id" id="plan_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title user</span>?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update this user?</span></h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
    <script src="{{asset('js/image.js')}}"></script>
    <script>
      let ids = [];
      $('[data-modal="modal"]').on('click', function() {
        if ($(this).data('id') === 'bulk') {
          $.each($('.list-check:checked'), function() {
            ids.push($(this).val());
          });
          $('#staff_id').val(ids);
        } else {
          $('#staff_id').val($(this).data('id'));
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
            $(this).data('title',$titleArr[0] + ' these staff members')
          })

        }else{
          $('#selectCountText').text('Item')

          $('[data-id="bulk"]').each(function() {
            let $title = $(this).data('title');
            let $titleArr = $title.split(' ');
            $(this).data('title',$titleArr[0] + ' this staff')
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
              $(this).data('title',$titleArr[0] + ' these staff members')
            })
          }else{
            $('#selectCountText').text('Item')

            $('[data-id="bulk"]').each(function() {
              let $title = $(this).data('title');
              let $titleArr = $title.split(' ');
              $(this).data('title',$titleArr[0] + ' this staff')
            })
          }
        });
      });

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
    {{--    <script src="{{asset('js/business.js')}}"></script>--}}
@endsection
