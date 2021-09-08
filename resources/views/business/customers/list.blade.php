@extends('layouts.business.app')

@section('title','All Customers')

@section('header_heading', "All Customers")

@section("header_subheading", "")

@section('content')
    <div class="row counter-wrapp scroller-h">
        <x-counter-box column="4" border_color="primary" text_color="primary" title="Total Customers"
                       total="{{$totalCustomers}}"
                       class="mt-lg-4 mt-3" />
        <x-counter-box column="4" border_color="green" text_color="green" title="Number of Orders"
                       total="{{$totalOrders}}"
                       class="mt-lg-4 mt-3" />
        <x-counter-box column="4" border_color="lightblue" text_color="lightblue" title="Amount Spent"
                       total="{{$totalSpent}}"
                       class="mt-lg-4 mt-3" />
    </div>
    <div class="row table-filter-wrap align-items-center justify-content-between mt-lg-5 mt-4">
        <div class="col-md-12 table-filter-wrap">
            <div class="col-filter">
                <nav class="tabs-head mobile-hide" id="allOrders">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="Allorders-tab" data-toggle="tab"
                           href="#Allorders" role="tab" aria-selected="true">All Customers</a>
                    </div>
                </nav>
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        All Customers
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link active" href="javascript:void(0)">All Customers</a>
                    </div>
                </div>
            </div>
            <div class="col-filter">
                <div class="table-misc d-flex justify-content-between">
                    {{--<div class="date-picker">
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
                    </div>--}}
                    <ul class="table-filter">
                        {{--<li>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#impCsv">
                                <img alt="" src="{{asset('business_assets/images/download.png')}}"> Import
                            </a>
                        </li>
                        <li><img alt="" src="{{asset('business_assets/images/upload.png')}}"> Export</li>--}}
                        <li>
                            <div class="dropdown order-list-drop">
                                <button class="dropdown-toggle" type="button" id="dropTFilter"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img alt="" src="{{asset('business_assets/images/filter.png')}}"> Filters
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropTFilter">
                                    <form>
                                    <div class="dropdown-box">
                                        <p class="dark-one font-weight-600">Total Orders</p>
                                        <div class="price-range-slider">
                                            <div id="slider-range"></div>
                                            <div class="slider-labels">
                                                <div class="caption">
                                                    <span id="slider-range-value1"></span>
                                                </div>
                                                <div class="caption">
                                                    <span id="slider-range-value2"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="min-value" value="">
                                            <input type="hidden" name="max-value" value="">
                                        </div>
                                    </div>
                                    <div class="dropdown-box">
                                        <p class="dark-one font-weight-600">Amount Spent</p>
                                        <div class="price-range-slider">
                                            <div id="slider-range-amount"></div>
                                            <div class="slider-labels">
                                                <div class="caption">
                                                    <span id="slider-amount-value1"></span>
                                                </div>
                                                <div class="caption">
                                                    <span id="slider-amount-value2"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="min-value" value="">
                                            <input type="hidden" name="max-value" value="">
                                        </div>
                                    </div>
                                    <hr class="mb-0">
                                    <div class="dropdown-box mb-3">
                                        <p class="dark-one font-weight-600">Member Since</p>
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
                                    </div>
                                    <div class="drop-footer grey-one d-flex justify-content-between">
                                        <button class="apply-filter dark-one"> Apply</button>
                                        <a href="{{url()->current()}}" class="clear-filter dark-two"> Clear</a>
                                        <a href="javascript:void(0)" class="cancel-filter dark-two" data-toggle="dropdown">Cancel</a>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @if(plan_has_permission(['customer-create']))
                        <li><a href="javascript:void(0)"
                               class="btn-size btn-rounded btn-primary add-customer-btn mobile-hide">
                                Add Customer
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <hr class="m-0">
    <h3 class="border-heading dark-one font-weight-700 mt-lg-5 mt-4 desktop-hide"> All Customers
        @if(plan_has_permission(['customer-create']))
            <a class="btn-primary btn-rounded btn-order add-customer-btn desktop-hide" href="javascript:void(0)"> Add Customer </a>
        @endif
    </h3>

    <div class="mt-3 mb-3">
        @include('flash::message')
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="All-order" role="tabpanel"
             aria-labelledby="Allorders-tab">
            <div class="sf-order">
                <div class="table-responsive scroll-bar-thin">
                    <table class="table table-space table-check">
                        <thead>
                        <tr>
                            @if(plan_has_permission(['customer-bulk-status', 'customer-bulk-delete']))
                            <th scope="col" class="custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                <label class="custom-control-label" for="checkAll">
                                    All
                                </label>
                            </th>
                            @endif
                            <th scope="col">All Customers</th>
                            <th scope="col">Contact</th>
                            <th scope="col">No of Orders</th>
                            <th scope="col">Amount Spend <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                            <th scope="col">Address <img src="{{asset('business_assets/images/sort.png')}}" alt="image"></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            @if(plan_has_permission(['customer-bulk-status', 'customer-bulk-delete']))
                            <td class="custom-checkbox show-selected">
                                <input type="checkbox" class="custom-control-input list-check" id="customCheck{{$loop->iteration+2}}" name="bulk_ids[]" value="{!! $customer->id !!}">
                                <label class="custom-control-label" for="customCheck{{$loop->iteration+2}}"></label>
                            </td>
                            @endif
                            <td>
                                <div class="table-order-no">
                                    <strong class="dark-one"><a href="#">{!! $customer->name !!}</a></strong>
                                    <p class="mb-0">Since: {!! \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') !!}</p>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 order-name">{!! $customer->phone !!}</p>
                                <p class="mb-0 order-name">
                                    <a href="mailto:johnsmith@gmail.com">{!! $customer->email !!}</a>
                                </p>
                            </td>
                            <td>
                                <p class="mb-0 order-store">{!! $customer->order_count !!}</p>
                            </td>
                            <td>
                                <p class="mb-0 order-store">{!! $customer->amount_spent !!}</p>
                            </td>
                            <td>
                                <p class="mb-0 order-store">{!! $customer->address !!}</p>
                            </td>
                            <td>
                                <div class="dropdown border-dropdown">
                                    <button
                                            class="dropdown-toggle"
                                            type="button"
                                            id="dropStatus"
                                            data-toggle="dropdown"
                                            aria-haspopup="false"
                                            aria-expanded="false"
                                    >
                                        {{ $customer->is_active == 1 ? 'Active' : 'Inactive' }}
                                    </button>
                                    @if(plan_has_permission(['customer-status']))
                                    <ul
                                            class="dropdown-menu dropdown-menu-right"
                                            aria-labelledby="dropStatus"
                                            style="position: absolute;
                                                    transform: translate3d(-63px,40px,0px);
                                                    top: 0px;left: 0px;will-change: transform;"
                                            x-placement="bottom-end"
                                    >
                                        @if($customer->is_active == \App\Constants\IStatus::ACTIVE)
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                   data-url="{{route('customers-status')}}"
                                                   data-status="{{\App\Constants\IStatus::DISABLE}}"
                                                   data-type="put"
                                                   data-toggle="modal"
                                                   data-modal="modal"
                                                   data-target="#confirmModal"
                                                   data-title="Inactive Customer"
                                                   data-id="{{$customer->id}}"
                                                >Inactive</a>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                   data-url="{{route('customers-status')}}"
                                                   data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                                   data-type="put"
                                                   data-toggle="modal"
                                                   data-modal="modal"
                                                   data-target="#confirmModal"
                                                   data-title="Active Customer"
                                                   data-id="{{$customer->id}}"
                                                >Active</a>
                                            </li>
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="table-action">
                                    @if(plan_has_permission(['customer-edit']))
                                    <a href="{{route('customers-detail',['id' => $customer->id])}}" class="edit-order">
                                        <img alt="" src="{{asset('admin_assets/images/edit.png')}}" />
                                    </a>
                                    @endif
                                    {{--<a href="#" class="print-order">
                                        <img alt="" src="{{asset('admin_assets/images/delete-gray.png')}}"
                                             data-url="{{route('customers-delete')}}"
                                             data-status=""
                                             data-type="delete"
                                             data-toggle="modal"
                                             data-modal="modal"
                                             data-target="#confirmModal"
                                             data-title="Delete this customer"
                                             data-id="{{$customer->id}}"/>
                                    </a>--}}
                                </div>
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @php $paginator = $customers->toArray() @endphp
                <div class="d-flex justify-content-between">
                    <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
                    {!! $customers->appends(request()->getQueryString())->links() !!}
                </div>
            </div>
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
                        <p class="mobile-hide"><span id="totalSelected">0</span> <span class="bg-transparent" id="selectCountText">Item</span> Selected</p>

                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn note-option"
                       data-url="{{route('customers-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Activate this customer"
                       data-id="bulk"
                    >
                        <span>Active</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('customers-bulk-status')}}"
                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                       data-type="put"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="InActive this customer"
                       data-id="bulk"
                    >
                        <span>InActive</span>
                    </a>
                </li>
                {{--<li>
                    <a href="javascript:void(0)" class="item-btn import-option"
                       data-url="{{route('customers-bulk-delete')}}"
                       data-type="delete"
                       data-toggle="modal"
                       data-modal="modal"
                       data-target="#confirmModal"
                       data-title="Delete this customer"
                       data-id="bulk"
                    >
                        <span>Delete</span>
                    </a>
                </li>--}}
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
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title customer</span>?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update this customer?</span></h4>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Ok</span></button>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">Cancel </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extras')
    <!-- Modal -->
    <div class="modal fade customer-modal" id="impCsv" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="font-weight-700 dark-one mb-2">Import Customers from CSV file</h3>
                    <div class="form-group mt-4 mb-4 w-75 ml-auto mr-auto">
                        <div class="form-icon">
                            <input type="url" placeholder="C/:"
                                   class="form-control sm-radius-control white-border-control">
                            <span>
                                <img alt="" src="images/folder.png">
                            </span>
                        </div>
                    </div>
                    <h4 class="dark-two mb-3">
                        Download a sample file CSV file <span class="dark-one font-weight-600">Click Here</span>
                    </h4>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary ml-1 mr-1"> Upload </a>
                    <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">
                        Cancel </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Customer Side Bar -->
    <div id="customers">
        <add-customer
                countries_url="{{api_url('countries')}}"
                states_url="{{api_url('states')}}"
                save_customer_url="{{route('customer-store')}}"
        >
        </add-customer>
    </div>

    <div class="body-overlay"></div>

@endsection


@section('scripts')
    <script src="{{asset_timestamp('js/customer.js')}}"></script>
    <script src="{{asset('admin_assets/js/select2.min.js')}}"></script>

    <script>
      let ids = [];
      $('[data-modal="modal"]').on('click', function() {
        if ($(this).data('id') === 'bulk') {
          $.each($('.list-check:checked'), function() {
            ids.push($(this).val());
          });
          $('#customer_id').val(ids);
        } else {
          $('#customer_id').val($(this).data('id'));
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

        checkSelectedItems()
      });

      $(function() {
        $('.list-check').on('change', function() {
          if ($('.list-check:checked').length === $('.list-check').length) {
            $('#checkAll').prop('checked', true);
          } else {
            $('#checkAll').prop('checked', false);
          }
          $('#totalSelected').text($('.list-check:checked').length);

          checkSelectedItems()
        });
      });

      function checkSelectedItems(){
        if ($('.list-check:checked').length > 1){
          $('#selectCountText').text('Items')

          $('[data-id="bulk"]').each(function() {
            let $title = $(this).data('title');
            let $titleArr = $title.split(' ');
            $(this).data('title',$titleArr[0] + ' these customers')
          })

        }else{
          $('#selectCountText').text('Item')

          $('[data-id="bulk"]').each(function() {
            let $title = $(this).data('title');
            let $titleArr = $title.split(' ');
            $(this).data('title',$titleArr[0] + ' this customer')
          })
        }
      }
    </script>
@endsection
