@extends('layouts.admin.app')

@section('title', 'Plans')
@section('heading', 'Plans')

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
                        <a class="nav-item nav-link @if(empty($showUpdateRoletab)) active @endif @if(empty($showRoleListingtab)) active @endif"
                           id="Users-tab" data-toggle="" href="{{route('admin-user-list')}}" role=""
                           aria-controls="Users" aria-selected="true">
                            Plans
                        </a>

                    </div>
                </nav>

                <hr class="m-0"/>
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade @if(empty($showUpdateRoletab)) active show @endif" id="Users"
                         role="tabpanel" aria-labelledby="Users">
                        <div class="col-12"> @include('flash::message')</div>
                        <div class="pro-table-seting">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="font-weight-700 dark-one">
                                    All Plans
                                </h4>
                                <a class="btn-size btn-rounded btn-primary" href="{{ route('admin-plans-add') }}"
                                   data-toggle="" data-target="">
                                    Add New
                                </a>
                            </div>
                            <div class="table-responsive scroll-bar-thin">
                                <table class="table table-space table-check">
                                    <thead>
                                    <tr>
{{--                                        <th scope="col" class="custom-checkbox">--}}
{{--                                            <input type="checkbox" class="custom-control-input" id="customCheck1"/>--}}
{{--                                            <label class="custom-control-label" for="customCheck1">--}}
{{--                                                <!-- <span class="ml-4">All</span> -->--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
                                        <th scope="col" class="pl-4">Title</th>
                                        <th scope="col">Montly price</th>
                                        <th scope="col">Yearly Pirce</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($plans))
                                        @foreach($plans  as $key=> $plan)

                                            <tr>
{{--                                                <td class="custom-checkbox show-selected">--}}
{{--                                                    <input type="checkbox" class="custom-control-input"--}}
{{--                                                           id="customCheck{{$key + 2}}"/>--}}
{{--                                                    <label class="custom-control-label"--}}
{{--                                                           for="customCheck{{$key + 2}}"></label>--}}
{{--                                                </td>--}}
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="pro-thumb">
                                                            <img alt=""
                                                                 src="{{$plan->profilethumb ?? ''}}"/>
                                                        </div>
                                                        <div class="table-order-no ml-3">
                                                            <strong class="dark-one"><a
                                                                    href="#">{{ isset($plan) ? $plan->title : ""}}</a></strong>
                                                            <p class="mb-0">{{ isset($plan) ? $plan->description : ""}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 order-name">AED {{ isset($plan->monthly_price) ? $plan->monthly_price : ""}} </p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 order-name">AED {{ isset($plan->yearly_price) ? $plan->yearly_price : ""}} </p>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropStore1" role="button"
                                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span id="dropdown-text-{{ $plan->id }}">
                                               @if(!empty($plan))
                                                            @if($plan->is_active ==1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        @endif
                                                    </span>


                                                </span>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropStore1">
                                                            <a class="dropdown-item" id=""
                                                               data-toggle="modal"
                                                               data-id="{{$plan->id}}"
                                                               data-url="{{route('plan-Status-Update')}}"
                                                               data-modal="modal"
                                                               data-type="post"
                                                               data-target="#confirmModal"
                                                               data-title="active plan"
                                                               data-description="active this plan"
                                                               data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                                               href="javascript:void(0)">
                                                                Active
                                                            </a>
                                                            <a class="dropdown-item" id=""
                                                               data-toggle="modal"
                                                               data-id="{{$plan->id}}"
                                                               data-url="{{route('plan-Status-Update')}}"
                                                               data-modal="modal"
                                                               data-type="post"
                                                               data-target="#confirmModal"
                                                               data-title="inactive plan"
                                                               data-description="inactive this plan"
                                                               data-status="{{\App\Constants\IStatus::DISABLE}}"
                                                               href="javascript:void(0)">
                                                                Inactive
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-action">
                                                        <a href="{{ route('admin-plans-edit', ['id' => $plan->id])}}"
                                                           class="edit-order mr-3">
                                                            <img alt=""
                                                                 src="{{asset('admin_assets/images/edit1.png')}}"/>
                                                        </a>
                                                        <a href="javascript:void(0);" class="print-order"
                                                           data-toggle="modal"
                                                           data-id="{{$plan->id}}"
                                                           data-url="{{route('admin-plans-delete')}}"
                                                           data-modal="modal"
                                                           data-type="delete"
                                                           data-target="#confirmModal"
                                                           data-title="Delete plan"
                                                           data-description="Delete this plan"
                                                        >
                                                            <img alt="" src="{{asset('admin_assets/images/delete.png')}}" />
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            @php $paginator = $plans->toArray() @endphp
                            <div class="d-flex justify-content-between">
                                <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}} of {{ $paginator['total'] }} records</p>
                                {!! $plans->appends(request()->getQueryString())->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="plan_id" id="plan_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Delete Plan</span>?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="description" class="text-lowercase">Delete this plan</span>?</h4>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1" data-dismiss="modal">Cancel </a>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1"><span data-modal-title="title">Delete</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extras')
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

        // alert("your in");
        function planStatusChange (plan_id, status_id) {

            $('.dropdown-toggle').dropdown('hide');
            if (plan_id != '' && status_id != '') {
                $.ajax({
                    url: '{{route('plan-Status-Update')}}',
                    type: 'GET',
                    dataType: 'json',
                    data: { plan_id: plan_id, status_id: status_id },
                    success: function (data) {
                        console.log(data);
                        $('#dropdown-text-'+plan_id).text(data)
                    }
                })
            } else {alert('Error!, Plan id not found failure From php side!!! ')}
        }

        $('[data-modal="modal"]').on('click', function(){
          $('#plan_id').val($(this).data('id'));
          $('#status_id').val($(this).data('status'));
          $('[data-modal-title="title"]').text($(this).data('title'))
          $('[data-modal-title="description"]').text($(this).data('description'))
          $('#confirmForm').attr('action',$(this).data('url'))
          $('#method').val($(this).data('type'))
          $
        });
    </script>


@endsection
