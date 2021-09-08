@extends('layouts.business.setting-layout')

@section('title','Users')

@section('header_heading', "All Users")

@section("header_subheading", "Overview")

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
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                <nav class="tabs-head mobile-hide" id="allOrders">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @if(plan_permission('user'))
                            <a class="nav-item nav-link @if(empty($showUpdateRoletab)) active @endif @if(empty($showRoleListingtab)) active @endif"
                               id="Users-tab" data-toggle="" href="{{route('user-list')}}" role=""
                               aria-controls="Users" aria-selected="true">
                                Users
                            </a>
                        @endif
                        @if(plan_permission('role'))
                            <a class="nav-item nav-link @if(!empty($showRoleListingtab)) active @endif"
                               id="roleList-tab"
                               data-toggle="" href="{{route('role-list')}}" role=""
                               aria-controls="roleList" aria-selected="false">
                                Roles
                            </a>
                        @endif
                        {{-- <a class="nav-item nav-link" id="addRole-tab" data-toggle="" href="{{ route('user-add') }}" role=""
                           aria-controls="addRole" aria-selected="false">
                            Add User
                        </a>
                        <a class="nav-item nav-link" id="addRole-tab" data-toggle="tab" href="#addRole" role="tab"
                           aria-controls="addRole" aria-selected="false">
                            Add Role
                        </a> --}}
                        @if(!empty($showUpdateRoletab))
                            <a class="nav-item nav-link @if(!empty($showUpdateRoletab)) active show @endif"
                               id="editRole-tab" data-toggle="tab" href="#editRole" role="tab"
                               aria-controls="editRole" aria-selected="false">
                                Edit Role
                            </a>
                        @endif
                    </div>
                </nav>
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Users
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link active" href="javascript:void(0)">
                            Users
                        </a>
                        <a class="nav-item nav-link" href="javascript:void(0)">
                            Roles
                        </a>
                        <a class="nav-item nav-link" href="javascript:void(0)">
                            Add Role
                        </a>
                    </div>
                </div>
                <hr class="m-0" />
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade @if(empty($showUpdateRoletab)) active show @endif" id="Users"
                         role="tabpanel" aria-labelledby="Users">
                        <div class="col-12"> @include('flash::message')</div>
                        <div class="pro-table-seting">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="font-weight-700 dark-one">
                                    All Users
                                </h4>
                                @if(plan_has_permission(['user-create']))
                                    <a class="btn-size btn-rounded btn-primary" href="{{ route('user-add') }}"
                                       data-toggle="" data-target="">
                                        Add New
                                    </a>
                                @endif
                            </div>
                            <div class="table-responsive scroll-bar-thin">
                                <table class="table table-space table-check">
                                    <thead>
                                    <tr>
                                        @if(plan_has_permission(['user-bulk-status','user-bulk-delete']))
                                            <th scope="col" class="custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                                <label class="custom-control-label" for="customCheck1">
                                                    <!-- <span class="ml-4">All</span> -->
                                                </label>
                                            </th>
                                        @endif
                                        <th scope="col" class="pl-4">User Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Store</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($users))
                                        @foreach($users  as $key=> $user)
                                            <?php
                                            $status = \App\Helpers\CommonHelper::getStatus($user->is_active);
                                            ?>
                                            <tr>
                                                @if(plan_has_permission(['user-bulk-status', 'user-bulk-delete']))
                                                    <td class="custom-checkbox show-selected">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="customCheck{{$key + 2}}" />
                                                        <label class="custom-control-label"
                                                               for="customCheck{{$key + 2}}"></label>
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="pro-thumb">
                                                            <img alt=""
                                                                 src="{{$user->profilethumb}}" />
                                                        </div>
                                                        <div class="table-order-no ml-3">
                                                            <strong class="dark-one"><a
                                                                        href="#">{{ isset($user) ? $user->name : ""}}</a></strong>
                                                            <p class="mb-0">{{ isset($user) ? $user->email : ""}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 order-name"> @foreach($user->roles  as $key=> $userRole) {{ isset($userRole) ? $userRole->name : ""}} @endforeach</p>
                                                </td>
                                                <td><p class="mb-0 order-name">Store 1</p></td>
                                                <td>
                                                    {{--<div class="dropdown">
                                                <span class="dropdown-toggle" id="dropStore1" role="button"
                                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span id="dropdown-text-{{ $user->id }}">
                                               @if(!empty($user))
                                                            @if($user->is_active ==1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        @endif
                                                    </span>


                                                </span>
                                                        @if(plan_has_permission(['user-status']))
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropStore1">
                                                            <a class="dropdown-item" id=""
                                                               onclick="userStatusChange({{ $user->id }},1)"
                                                               href="javascript:void(0)">
                                                                Active
                                                            </a>
                                                            <a class="dropdown-item" id=""
                                                               onclick="userStatusChange({{ $user->id }},2)"
                                                               href="javascript:void(0)">
                                                                Inactive
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif--}}
                                                    <div class="dropdown">
                                                        <span class="dropdown-toggle" id="dropTable1" role="button" data-toggle="dropdown"
                                                              aria-haspopup="true" aria-expanded="false">{!! $status !!}</span>
                                                        @if(!\App\Helpers\CommonHelper::isBusinessAdmin())
                                                        @if(plan_has_permission(['user-status']))
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                 aria-labelledby="dropTable1">
                                                                @if($status == 'InActive')
                                                                    <a class="dropdown-item"
                                                                       href="javascript:void(0)"
                                                                       data-toggle="modal"
                                                                       data-modal="modal"
                                                                       data-target="#confirmModal"
                                                                       data-title="Activate"
                                                                       data-url="{{route('user-status')}}"
                                                                       data-status="{{\App\Constants\IStatus::ACTIVE}}"
                                                                       data-type="put"
                                                                       data-id="{{$user->id}}"
                                                                    >
                                                                        Active
                                                                    </a>
                                                                @else
                                                                    <a class="dropdown-item"
                                                                       href="javascript:void(0)"
                                                                       data-url="{{route('user-status')}}"
                                                                       data-status="{{\App\Constants\IStatus::DISABLE}}"
                                                                       data-type="put"
                                                                       data-toggle="modal"
                                                                       data-modal="modal"
                                                                       data-target="#confirmModal"
                                                                       data-title="InActivate"
                                                                       data-id="{{$user->id}}"
                                                                    >
                                                                        Inactive
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-action">
                                                        @if(plan_has_permission(['user-edit']))
                                                            <a href="{{ route('user-edit', ['id' => $user->id])}}"
                                                               class="edit-order mr-3">
                                                                <img alt=""
                                                                     src="{{asset('admin_assets/images/edit1.png')}}" />
                                                            </a>
                                                        @endif
                                                        @if($user->user_type_id <= 0)
                                                            @if(plan_has_permission(['user-delete']))
                                                                <a class="print-order" data-toggle="modal"
                                                                   data-target="#cancelRefund-{{ $user->id }}">
                                                                    <img alt=""
                                                                         src="{{asset('admin_assets/images/delete.png')}}" />
                                                                </a>
                                                                <div class="modal fade refund-modal"
                                                                     id="cancelRefund-{{ $user->id }}" tabindex="-1"
                                                                     role="dialog" aria-modal="true"
                                                                     style="padding-right: 17px;">
                                                                    <div class="modal-dialog modal-dialog-centered"
                                                                         role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body">
                                                                                <form method="POST"
                                                                                      action='{{route('user-delete', ['id' => $user->id])}}'>
                                                                                    <h4 class="dark-two mb-3">Are you
                                                                                        sure to delete this user?</h4>
                                                                                    <h2 class="font-weight-700 dark-one mb-2">
                                                                                        Are You Sure?</h2>
                                                                                    @csrf
                                                                                    {{method_field('DELETE')}}
                                                                                    <button class="btn-size btn-rounded btn-primary ml-1 mr-1">
                                                                                        Ok
                                                                                    </button>
                                                                                    <a href="javascript:void(0)"
                                                                                       class="btn-size btn-rounded btn-gray ml-1 mr-1"
                                                                                       data-dismiss="modal"> Cancel </a>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            @php $paginator = $users->toArray() @endphp
                            <div class="d-flex justify-content-between">
                                <p class="ml-5">Showing {{$paginator['from']}} - {{$paginator['to']}}
                                    of {{ $paginator['total'] }} records</p>
                                {!! $users->appends(request()->getQueryString())->links() !!}
                            </div>
                        </div>
                    </div>

                    @if(!empty($showUpdateRoletab))
                        <div class="tab-pane fade @if(!empty($showUpdateRoletab)) active show @endif " id="editRole"
                             role="tabpanel" aria-labelledby="editRole">

                            @if($errors->has('role_name'))
                                <div class="alert alert-danger">
                                    <p><strong>Error!</strong></p>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('roles.update',[!empty($singlerole) ? $singlerole->id : ""]) }}"
                                  method="post">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <h4 class="font-weight-700 dark-one mb-4">Manage Role</h4>
                                <div class="row">
                                    <div class="col-sm-6 form-group mb-4">
                                        <label class="font-weight-600 dark-one mb-2">Edit Role</label>
                                        <input type="text" name="role_name"
                                               value="{{!empty($singlerole) ? $singlerole->name : ""}} " placeholder=""
                                               class="form-control order-edit-control @error('name') danger-border @enderror " />

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="row">
                                    @php
                                        $outercount = 1;$innercount = 1;
                                    @endphp
                                    @foreach($groups as $group)
                                        @php
                                            $outercount++;
                                        @endphp
                                        <div class="col-sm-6">
                                            <div class="form-group mb-4">
                                                <h4 class="font-weight-700 dark-one mb-4">{{$group->group}}</h4>
                                                @foreach($permissions as $key => $permission)
                                                    @php
                                                        $innercount++;
                                                    @endphp
                                                    @if($permission->group==$group->group)
                                                        <div class="custom-checkbox lgcheck-text mb-3">
                                                            <input type="checkbox" name="permission[]"
                                                                   value="{{ $permission['id'] }}"
                                                                   class="custom-control-input"
                                                                   id="role{{ $permission['id'].$outercount.$innercount }}"
                                                                   @if(!empty($existingPermissions) && in_array($permission['id'], $existingPermissions)) checked @endif
                                                            />
                                                            <label class="custom-control-label w-100 h-100 pl-4"
                                                                   for="role{{ $permission['id'].$outercount.$innercount}}">
                                                                <span class="pl-2">{{ $permission['name']  }}</span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group mb-0 text-right">
                                    <hr class="mt-5 mb-3" />
                                    {{--                            <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3">Update</a>--}}
                                    <button class="btn-size btn-rounded btn-primary mr-3">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
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
                        <p class="mobile-hide">2 Items Selected</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn">
                        <span>Delete User</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="item-btn">
                        <span>Duplicate User</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('extras')
    <!-- Add New User -->
    <div class="modal fade customer-modal" id="addNewUser" tabindex="-1" role="dialog" aria-hidden="true">
        <form action="{{ route('user-store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-body">
                        <h3 class="font-weight-700 dark-one mb-2">Add New User</h3>
                        <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                            <div class="form-group">
                                <span class="add-brand" onclick="imguploaduser()">
                                    <img id="defaultimg"
                                         src="{{asset('admin_assets/images/customer-placeholder.png')}}" />

                                </span>

                                <input
                                        type="file"
                                        accept="image/x-png,image/gif,image/jpeg"
                                        class="d-none"
                                        id="imguploaduser"
                                        name="image"
                                />
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Name</label>
                                <input type="text" name="name"
                                       class="form-control sm-radius-control white-border-control" />
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Email</label>
                                <input type="email" name="owner_email"
                                       class="form-control sm-radius-control white-border-control" />
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Password</label>
                                <input type="password" name="password"
                                       class="form-control sm-radius-control white-border-control" />
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control sm-radius-control white-border-control" />
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Role</label>
                                <div class="form-icon">
                                    <select name="userRole" class="form-control sm-radius-control white-border-control">
                                        <option>-- Select --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    <span>
                                    <img alt="" src="{{asset('admin_assets/images/angledown.png')}}" />
                                </span>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn-size btn-rounded btn-gray ml-1 mr-1"
                           data-dismiss="modal">
                            Cancel
                        </a>
                        <button class="btn-size btn-rounded btn-primary ml-1 mr-1">
                            Add
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="modal fade refund-modal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="" id="confirmForm" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="" id="method">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="status_id" id="status_id">
                        <h2 class="font-weight-700 dark-one mb-2"><span data-modal-title="title">Title User</span>?</h2>
                        <h4 class="dark-two mb-3">Are you sure to <span data-modal-title="title" class="text-lowercase">Update this User?</span></h4>
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
    <script>
      $.ajaxSetup({
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{csrf_token()}}"
        }
      });

      // alert("your in");
      function userStatusChange (user_id, status_id) {

        $('.dropdown-toggle').dropdown('hide');
        if (user_id != '' && status_id != '') {
          $.ajax({
            url: '/admin/users/statuschange',
            type: 'GET',
            dataType: 'json',
            data: { user_id: user_id, status_id: status_id },
            success: function(data) {
              $('#dropdown-text-' + user_id).text(data);
            }
          });
        } else {alert('Error!, Business id not found failure From php side!!! ');}
      }

      function DeleteUserById () {

      }
    </script>
    <script>
      function imguploaduser () {
        $('#imguploaduser').trigger('click');
      }

      //$('.dropdown-toggle').dropdown('hide');
      function deleteUser () {
        $('#deleteuserForm').submit();
      }
    </script>

    <script>
      let ids = [];
      $('[data-modal="modal"]').on('click', function(){
        if ($(this).data('id') === 'bulk'){
          $.each($('.list-check:checked'), function(){
            ids.push($(this).val())
          })
          $('#user_id').val(ids)
        } else {
          $('#user_id').val($(this).data('id'));
        }
        $('#status_id').val($(this).data('status'));
        $('[data-modal-title="title"]').text($(this).data('title'))
        $('#confirmForm').attr('action',$(this).data('url'))
        $('#method').val($(this).data('type'))
        $
      });
    </script>


@endsection
