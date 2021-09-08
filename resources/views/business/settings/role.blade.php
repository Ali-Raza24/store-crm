@extends('layouts.business.setting-layout')

@section('title','All Roles')

@section('header_heading', "All Roles")

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
                        <a class="nav-item nav-link"
                           id="Users-tab" data-toggle="" href="{{route('user-list')}}" role=""
                           aria-controls="Users" aria-selected="true">
                            Users
                        </a>
                        @endif
                        <a class="nav-item nav-link @if(!empty($showRoleListingtab)) active @endif" id="roleList-tab"
                           data-toggle="" href="{{route('role-list')}}" role=""
                           aria-controls="" aria-selected="false">
                            Roles
                        </a>
                        @if(plan_has_permission(['role-create']))
                        <a class="nav-item nav-link" id="addRole-tab" data-toggle="" href="{{ route('role-add') }}" role=""
                           aria-controls="addRole" aria-selected="false">
                            Add Role
                        </a>
                        @endif
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
                        @if(plan_permission('user'))
                            Users
                        @else
                            Role
                        @endif
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        @if(plan_permission('user'))
                        <a class="nav-item nav-link active" href="javascript:void(0)">
                            Users
                        </a>
                        @endif
                        @if(plan_permission('role'))
                        <a class="nav-item nav-link" href="javascript:void(0)">
                            Role List
                        </a>
                        @endif
                        @if(plan_has_permission(['user-create']))
                        <a class="nav-item nav-link" href="javascript:void(0)">
                            Add Role
                        </a>
                            @endif
                    </div>
                </div>
                <hr class="m-0"/>
                <div class="tab-content mt-5" id="nav-settingContent">

                    <div class="tab-pane fade active show" id="roleList" role="tabpanel" aria-labelledby="roleList">
                        <div class="col-12"> @include('flash::message')</div>
                        <div class="pro-table-seting">
                            <h4 class="font-weight-700 dark-one">All Roles</h4>
                            <div class="table-responsive wide-table radius-10 scroll-bar-thin mt-3">
                                <table class="table table">
                                    <tbody>
                                    <!-- loop for roles -->@foreach ($roles as $role)
                                        <tr>
                                            <td><h6 class="dark-one font-weight-700">{{$role->name}}</h6></td>

                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <div class="wide-left">
                                                        <!-- loop for permissions where permission.roleid=role.id -->
                                                        @foreach($role->permissions as $permission)
                                                            <p class="mb-1 order-name">

                                                                {{$permission->description}}
                                                            </p>
                                                        @endforeach
                                                    </div>
                                                    @if(plan_has_permission(['role-edit']))
                                                    <div class="wide-right">
                                                        <h4>
                                                            <a class="table-link primary-text font-weight-600"
                                                               href="{{route('role-edit', ['id' => $role->id])}}">Edit</a>
                                                        </h4>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><p class="dark-one m-3"></p></div>
                                <div class="col-md-6">
                                    <br/>
                                    {{ $roles->links() }}
                                    {{-- @include('extras.pagination') --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="addRole" role="tabpanel" aria-labelledby="addRole">
                        <form action="{{ route('role-store') }}" method="post">
                            {{ csrf_field() }}
                            <h4 class="font-weight-700 dark-one mb-4">Manage Role</h4>
                            <div class="row">
                                <div class="col-sm-6 form-group mb-4">
                                    <label class="font-weight-600 dark-one mb-2">Add Roles</label>
                                    <input type="text" name="role_name" placeholder=""
                                           class="form-control order-edit-control @error('role_name') danger-border @enderror "/>

                                    @error('role_name')
                                    <div class="danger-bg input-info" role="alert">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror

                                </div>
                            </div>
                            @error('permission')
                            <div class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </div>
                            @enderror
                            <div class="row">
                                @foreach($groups as $group)
                                    <div class="col-sm-6">

                                        <div class="form-group mb-4">
                                            <h4 class="font-weight-700 dark-one mb-4">{{$group->group}}</h4>

                                            @foreach($permissions as $permission)
                                                @if($permission->group==$group->group)
                                                    <div class="custom-checkbox lgcheck-text mb-3">
                                                        <input type="checkbox" name="permission[]"
                                                               value="{{ $permission['id'] }}"
                                                               class="custom-control-input"
                                                               id="role{{ $permission['id'] }}"/>
                                                        <label class="custom-control-label w-100 h-100 pl-4"
                                                               for="role{{ $permission['id'] }}">
                                                            <span class="pl-2">{{ $permission['name'] }}</span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group mb-0 text-right">
                                <hr class="mt-5 mb-3"/>
                                {{--                            <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3">Update</a>--}}
                                <button class="btn-size btn-rounded btn-primary mr-3">
                                    Save
                                </button>
                            </div>
                        </form>
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
                                               class="form-control order-edit-control @error('name') danger-border @enderror "/>

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
                                    <hr class="mt-5 mb-3"/>
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
                            <img src="{{asset('admin_assets/images/close-wgite.png')}}" alt="image"/>
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
        function userStatusChange (user_id, status_id) {

            $('.dropdown-toggle').dropdown('hide');
            if (user_id != '' && status_id != '') {
                $.ajax({
                    url: '/admin/users/statuschange',
                    type: 'GET',
                    dataType: 'json',
                    data: { user_id: user_id, status_id: status_id },
                    success: function (data) {
                        $('#dropdown-text-'+user_id).text(data)
                    }
                })
            } else {alert('Error!, Business id not found failure From php side!!! ')}
        }
        function DeleteUserById(){


        }
    </script>
    <script>
        function imguploaduser () {
            $('#imguploaduser').trigger('click')
        }
        //$('.dropdown-toggle').dropdown('hide');
        function deleteUser(){
            $('#deleteuserForm').submit();
        }
    </script>


@endsection
