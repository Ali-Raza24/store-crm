@extends('layouts.admin.app')

@section('title', 'Users')
@section('heading', 'Users')

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
                        <a class="nav-item nav-link active show"
                           id="Users-tab" data-toggle="" href="{{route('admin-user-list')}}" role=""
                           aria-controls="Users" aria-selected="true">
                            Users
                        </a>
                        <a class="nav-item nav-link @if(!empty($showRoleListingtab)) active @endif" id="roleList-tab"
                           data-toggle="" href="{{route('admin-role-list')}}" role=""
                           aria-controls="roleList" aria-selected="false">
                            Roles
                        </a>
                        <a class="nav-item nav-link" id="addRole-tab" data-toggle="" href="{{ route('admin-user-add') }}" role=""
                           aria-controls="addRole" aria-selected="false">
                            Add User
                        </a>
                        {{-- <a class="nav-item nav-link active show"
                            id="editUser-tab" data-toggle="tab" href="#" role="tab"
                            aria-controls="editRole" aria-selected="false">
                            Edit User
                        </a> --}}
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
                <hr class="m-0"/>
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade active show " id="editRole" role="tabpanel" aria-labelledby="editRole">
                        {{-- @if($errors->any())
                                <div class="alert alert-danger">
                                    <p><strong>Error!</strong></p>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                        @if($errors->any())
                        <div class="alert alert-danger col-md-12">
                            <ul>
                                <li><strong>Error! </strong>Please fill out required fields</li>
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('admin-user-update', [!empty($userdetails) ? $userdetails->id : ""]) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <h4 class="font-weight-700 dark-one mb-2">Edit User</h4>
                            <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                                <div class="form-group">
                                    {{-- <span class="add-brand" onclick="imguploaduser()">
                                        <img id="defaultimg"
                                                src="{{!empty($userdetails->image->thumbnail) ? asset('thumbnails/users/').'/'.$userdetails->image->thumbnail : asset('admin_assets/images/customer-placeholder.png')}}"/>

                                    </span>

                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" class="d-none" id="imguploaduser" name="images[]" /> --}}

                                    <input type="file" id="userUpload" name="images[]" class="d-none">
                                    <div class="bg-gray uploader sm-radius-control cursor-pointer" id="pic">
                                        <span>

                                            @if(empty($userdetails->image->thumbnail))
                                                <img alt="" id="userPreview"
                                                        src="{{asset('admin_assets/images/upload-img1.png')}}"
                                                        style="max-width: 504px; max-height:147px">
                                            @else
                                                <img alt="" id="userPreview"
                                                        src="{{$userdetails->profilethumb}}"
                                                        style="max-width: 504px; max-height:147px">
                                            @endif

                                        </span>
                                    </div>
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-600 dark-one mb-2">Name</label>
                                    <input type="text" name="name" value="{{!empty(old('name')) ? old('name') : $userdetails->name}}" class="form-control sm-radius-control white-border-control @error('name') danger-border @enderror"/>

                                    @error('name')
                                    <div class="danger-bg input-info" role="alert">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-600 dark-one mb-2">Email</label>
                                    <input type="email" name="email" readonly value="{{!empty(old('email')) ? old('email') : $userdetails->email}}" class="form-control sm-radius-control white-border-control"/>

                                    @error('email')
                                    <div class="danger-bg input-info" role="alert">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-600 dark-one mb-2">Password</label>
                                    <input type="password" name="password" class="form-control sm-radius-control white-border-control @error('password') danger-border @enderror"/>

                                    @error('password')
                                    <div class="danger-bg input-info" role="alert">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-600 dark-one mb-2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control sm-radius-control white-border-control @error('password') danger-border @enderror"/>

                                    @error('password')
                                    <div class="danger-bg input-info" role="alert">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group text-left">
                                    <label class="font-weight-600 dark-one mb-2">Role</label>
                                    <div class="form-icon">
                                        <select name="userRole" class="form-control sm-radius-control white-border-control @error('userRole') danger-border @enderror">
                                            <option value="">-- Select --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}"

                                                    @if(!empty(old('userRole')) && $role->id == old('userRole'))
                                                        selected
                                                    @endif

                                                    @if(empty(old('userRole')) && isset($userdetails->role[0]->id) && $role->id == $userdetails->role[0]->id)) selected @endif

                                                    >{{$role->name}}</option>
                                            @endforeach

                                            @error('userRole')
                                                <div class="danger-bg input-info" role="alert">
                                                    <p>{{ $message }}</p>
                                                </div>
                                            @enderror
                                        </select>
                                        <span>
                                        <img alt="" src="{{asset('admin_assets/images/angledown.png')}}"/>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn-size btn-rounded btn-primary ml-1 mr-1">
                                Update
                            </button>
                        </form>

                    </div>
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

@section('extras')
    <!-- Add New User -->
    <div class="modal fade customer-modal" id="addNewUser" tabindex="-1" role="dialog" aria-hidden="true">
        <form action="{{ route('admin-user-store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-body">
                        <h3 class="font-weight-700 dark-one mb-2">Add New User</h3>
                        <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                            <div class="form-group">
                                <span class="add-brand" onclick="imguploaduser()">
                                    <img id="defaultimg"
                                         src="{{asset('admin_assets/images/customer-placeholder.png')}}"/>

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
                                       class="form-control sm-radius-control white-border-control"/>
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Email</label>
                                <input type="email" name="email"
                                       class="form-control sm-radius-control white-border-control"/>
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Password</label>
                                <input type="password" name="password"
                                       class="form-control sm-radius-control white-border-control"/>
                            </div>
                            <div class="form-group text-left">
                                <label class="font-weight-600 dark-one mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control sm-radius-control white-border-control"/>
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
                                    <img alt="" src="{{asset('admin_assets/images/angledown.png')}}"/>
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

        $(function () {
            $('#pic').unbind().on('click', function(){
                $('#userUpload').trigger('click')
            });

            $('#userUpload').on('change', function () {
                readURL(this, 'userPreview');
            });

        });

        function readURL(input, preview) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#'+preview)
                .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


@endsection
