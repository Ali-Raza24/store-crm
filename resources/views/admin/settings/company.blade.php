@extends('layouts.admin.app')

@section('title', 'Company Information')
@section('heading', 'Company Information')

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
            <div class="card-repeat profile-adder pb-5 mt-4">
                <div class="profile-settings">
                    <img alt="" src="{{asset('admin_assets/images/logo-social.jpg')}}"/>
                    <a href="javascript:void(0)" class="profile-add">+</a>
                </div>
                <p class="profile-name dark-one font-weight-700 mb-0 text-center">John Smith</p>
                <p class="dark-two profile-tagline text-center mb-0">johnsmith@gmail.com</p>
                <div class="text-center mb-3">
                    <a href="javascript:void(0)" class="text-primary">Edit Account Info</a>
                </div>
                @include('admin.settings.sidebar')
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('admin.settings.general.navbar')
                <div class="dropdown tabs-dropdown desktop-hide">
                    <button class="dropdown-toggle" type="button" id="dropTab" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Store
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropTab">
                        <a class="nav-item nav-link {{request()->routeIs('admin-company-setting') ? 'active' : ''}}" href="{{route('admin-company-setting')}}">
                            Company Information
                        </a>
                        <a class="nav-item nav-link {{request()->routeIs('admin-testimonials-tab') ? 'active' : ''}}" href="{{ route('admin-testimonials-tab') }}">
                            Testimonials
                        </a>
                        <a class="nav-item nav-link" href="javascript:void(0)">
                            Emirates
                        </a>
                        <a class="nav-item nav-link active" href="javascript:void(0)">
                            Featured Business
                        </a>
                    </div>
                </div>

                <hr class="m-0"/>
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade {{request()->routeIs('admin-company-setting') ? 'show active' : ''}}" id="settStore" role="tabpanel" aria-labelledby="settStore">
                        <form action='{{ route('admin-company-page-store') }}' method='post' id='updatepageform'>
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one mb-2">Name</label>
                                    <input type="text" name='company[name]' value='@if(!empty(old('company')['name'])){{old('company')['name'] ?? ''}}@elseif(!empty($Company['name'])){{$Company['name'] ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('company.name') danger-border @enderror"/>
                                    @error('company.name')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one mb-2">Email</label>
                                    <input type="text" name='company[email]' value='@if(!empty(old('company')['email'])){{old('company')['email'] ?? ''}}@elseif(!empty($Company['email'])){{$Company['email'] ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('company.email') danger-border @enderror"/>
                                    @error('company.email')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one">Mobile</label>
                                    <input type="text" name='company[mobile]' value='@if(!empty(old('company')['mobile'])){{old('company')['mobile'] ?? ''}}@elseif(!empty($Company['mobile'])){{$Company['mobile'] ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('company.mobile') danger-border @enderror"/>
                                    @error('company.mobile')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one">Phone</label>
                                    <input type="text" name='company[phone]' value='@if(!empty(old('company')['phone'])){{old('company')['phone'] ?? ''}}@elseif(!empty($Company['phone'])){{$Company['phone'] ?? ''}}@endif' placeholder="" class="form-control order-edit-control @error('company.phone') danger-border @enderror"/>
                                    @error('company.phone')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label class="font-weight-600 dark-one">About</label>
                                    <textarea placeholder="" name='company[aboutinfo]'  class="form-control order-edit-control @error('company.aboutinfo') danger-border @enderror">@if(!empty(old('company')['aboutinfo'])){{old('company')['aboutinfo'] ?? ''}}@elseif(!empty($Company['aboutinfo'])){{$Company['aboutinfo'] ?? ''}}@endif</textarea>
                                    @error('company.aboutinfo')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one">Facebook</label>
                                    <input type="text" name='company[facebook]' value='@if(!empty(old('company')['facebook'])){{old('company')['facebook'] ?? ''}}@elseif(!empty($Company['facebook'])){{$Company['facebook'] ?? ''}}@endif' placeholder="John Smith " class="form-control order-edit-control @error('company.facebook') danger-border @enderror"/>
                                    @error('company.facebook')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one">Instagram</label>
                                    <input type="text" name='company[instagram]' value='@if(!empty(old('company')['instagram'])){{old('company')['instagram'] ?? ''}}@elseif(!empty($Company['instagram'])){{$Company['instagram'] ?? ''}}@endif' placeholder="Johnsmith@gmail.com" class="form-control order-edit-control @error('company.instagram') danger-border @enderror"/>
                                    @error('company.instagram')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one">Linked In</label>
                                    <input type="text" name='company[linkedin]' value='@if(!empty(old('company')['linkedin'])){{old('company')['linkedin'] ?? ''}}@elseif(!empty($Company['linkedin'])){{$Company['linkedin'] ?? ''}}@endif' placeholder="John Smith " class="form-control order-edit-control @error('company.linkedin') danger-border @enderror"/>
                                    @error('company.linkedin')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one">Twitter</label>
                                    <input type="text" name='company[twitter]' value='@if(!empty(old('company')['twitter'])){{old('company')['twitter'] ?? ''}}@elseif(!empty($Company['twitter'])){{$Company['twitter'] ?? ''}}@endif' placeholder="Johnsmith@gmail.com" class="form-control order-edit-control @error('company.twitter') danger-border @enderror"/>
                                    @error('company.twitter')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
{{--                                <div class="col-sm-6 form-group mb-3">--}}
{{--                                    <label class="font-weight-600 dark-one">Country</label>--}}
{{--                                    <select name='company[country_id]'>--}}
{{--                                        <option>Select</option>--}}
{{--                                        @foreach($allcountries as $country)--}}
{{--                                            <option value='{{$country->id}}'>{{$country->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}

{{--                                </div>--}}
                                <div class="form-group col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one mb-2">Country</label>

                                    <div class="form-icon">
                                        <select name='company[country_id]' class="order-edit-control form-control @error('company.country_id') danger-border @enderror">
                                            <option value="">--Select--</option>
                                            @foreach($allcountries as $country)
                                                <option value='{{$country->id}}' @if(!empty(old('company')['country_id'])) selected @elseif(!empty($Company['country_id']) && $Company['country_id']==$country->id) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <span><img src="http://localhost:8000/business_assets/images/angledown.png" alt="image"></span>
                                        @error('company.country_id')
                                        <div class="input-info danger-bg">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group mb-3">
                                    <label class="font-weight-600 dark-one">Emirate</label>
                                    <input type="text" name='company[emirate]' value='@if(!empty(old('company')['emirate'])){{old('company')['emirate'] ?? ''}}@elseif(!empty($Company['emirate'])){{$Company['emirate'] ?? ''}}@endif' placeholder="Johnsmith@gmail.com" class="form-control order-edit-control @error('company.emirate') danger-border @enderror"/>
                                    @error('company.emirate')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label class="font-weight-600 dark-one mb-2">Address</label>
                                    <input type="text" name='company[address]' value='@if(!empty(old('company')['address'])){{old('company')['address'] ?? ''}}@elseif(!empty($Company['address'])){{$Company['address'] ?? ''}}@endif' placeholder="Address" class="form-control order-edit-control @error('company.address') danger-border @enderror"/>
                                    @error('company.address')
                                    <div class="input-info danger-bg">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                        <div class="form-group mb-0 text-right">
                            <hr class="mt-5 mb-3"/>
                            <a href="javascript:void(0)" class="btn-size btn-rounded btn-primary mr-3" onclick='return  submitPageEditForm();'>Update</a>
                        </div>
                    </div>
                    </form>
                    <div class="tab-pane fade pro-table-seting" id="settNotificat" role="tabpanel" aria-labelledby="settNotificat">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-weight-700 dark-one">All Emirates</h4>
                            <a class="btn-size btn-rounded btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#addNewEmirates">
                                All Emirates
                            </a>
                        </div>
                        <div class="table-responsive scroll-bar-thin">
                            <table class="table table-space table-check">
                                <thead>
                                <tr>
                                    <th scope="col" class="custom-checkbox pl-0 pr-0">
                                        <input type="checkbox" class="custom-control-input" id="customCheck6-1"/>
                                        <label class="custom-control-label" for="customCheck6-1">
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0; $i<6; $i++)
                                    <tr>
                                        <td class="custom-checkbox show-selected pl-0 pr-0">
                                            <input type="checkbox" class="custom-control-input" id="customCheck6-{{$i+2}}"/>
                                            <label class="custom-control-label" for="customCheck6-{{$i+2}}"></label>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="table-order-no ml-3">
                                                    <strong class="dark-one">
                                                        <a href="#">John Smith</a>
                                                    </strong>
                                                    <p class="mb-0">Dec 02, 2020</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                            <span class="dropdown-toggle" id="dropStore1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Active
                                            </span>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropStore1">
                                                    <a class="dropdown-item" href="javascript:void(0)">
                                                        active
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0)">
                                                        Unactive
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-action">
                                                <a href="#" class="edit-order mr-3">
                                                    <img alt="" src="{{asset('admin_assets/images/edit1.png')}}"/>
                                                </a>
                                                <a href="#" class="print-order">
                                                    <img alt="" src="{{asset('admin_assets/images/delete.png')}}"/>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><p class="dark-one m-3">Showing 5 of 30 records</p></div>
                            <div class="col-md-6">
                                @include('extras.pagination')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade pro-table-seting {{request()->routeIs('admin-businesses-tab') ? 'show active' : ''}}" id="settPayment" role="tabpanel" aria-labelledby="settPayment">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-weight-700 dark-one">
                                All Featured
                            </h4>
                            <form class="header-search">
                                <div class="form-group form-icon">
                                    <input type="text" placeholder="Search your keyword..." class="form-control"/>
                                    <span>
                                        <img alt="" src="{{asset('admin_assets/images/search.png')}}"/>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive scroll-bar-thin">
                            <table class="table table-space table-check">
                                <thead>
                                <tr>
                                    <th scope="col" class="custom-checkbox pl-0 pr-0">
                                        <input type="checkbox" class="custom-control-input" id="customCheck7-1"/>
                                        <label class="custom-control-label" for="customCheck6-1">
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Featured</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0; $i<5; $i++)
                                    <tr>
                                        <td class="custom-checkbox show-selected pl-0 pr-0">
                                            <input type="checkbox" class="custom-control-input" id="customCheck7-2-{{$i+1}}"/>
                                            <label class="custom-control-label" for="customCheck7-2-{{$i+1}}"></label>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="table-order-no ml-3">
                                                    <strong class="dark-one">
                                                        <a href="#">Business Name</a>
                                                    </strong>
                                                    <p class="mb-0">Dec 02, 2020</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck7-2-2"/>
                                                <label class="custom-control-label" for="customCheck7-2-2"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><p class="dark-one m-3">Showing 5 of 30 records
                                </p>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('layouts.jquery')
    <script>
        //Form submit
        function submitPageEditForm(){
            document.getElementById("updatepageform").submit();
        }
    </script>
@endsection
