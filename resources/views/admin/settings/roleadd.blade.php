@extends('layouts.admin.app')

@section('title', 'Roles')
@section('heading', 'Roles')

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
                        <a class="nav-item nav-link"
                           id="Users-tab" data-toggle="" href="{{route('admin-user-list')}}" role=""
                           aria-controls="Users" aria-selected="true">
                            Users
                        </a>
                        <a class="nav-item nav-link " id="roleList-tab"
                           data-toggle="" href="{{route('admin-role-list')}}" role=""
                           aria-controls="" aria-selected="false">
                            Roles
                        </a>
                        <a class="nav-item nav-link active" id="addRole-tab" data-toggle="tab" href="#addRole" role="tab"
                           aria-controls="addRole" aria-selected="false">
                            Add Role
                        </a>
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
                            Role List
                        </a>
                        <a class="nav-item nav-link" href="javascript:void(0)">
                            Add Role
                        </a>
                    </div>
                </div>
                <hr class="m-0"/>
                <div class="tab-content mt-5" id="nav-settingContent">


                    <div class="tab-pane fade active show" id="addRole" role="tabpanel" aria-labelledby="addRole">
                        <form action="{{ route('admin-role-store') }}" method="post">
                            {{ csrf_field() }}
                            <h4 class="font-weight-700 dark-one mb-4">Manage Role</h4>
                            <div class="row">
                                <div class="col-sm-6 form-group mb-4">
                                    <label class="font-weight-600 dark-one mb-2">Add Roles</label>
                                    <input type="text" name="role_name" value="{{ old('role_name') }}" placeholder=""
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
                                            <h4 class="font-weight-700 dark-one mb-4 text-capitalize">{{$group->group}}</h4>

                                            @foreach($permissions as $permission)
                                                @if($permission->group == $group->group)
                                                    <div class="custom-checkbox lgcheck-text mb-3">
                                                        <input type="checkbox" name="permission[]"
                                                               value="{{ $permission['id'] }}"
                                                               class="custom-control-input"
                                                               id="role{{ $permission['id'] }}"
                                                               @if(!empty(old('permission')) && in_array($permission['id'], old('permission')))
                                                                checked
                                                               @endif
                                                               />

                                                               <label class="custom-control-label w-100 h-100 pl-4"
                                                               for="role{{ $permission['id'] }}">
                                                            <span class="pl-2">{{ $permission['description'] }}</span>
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
