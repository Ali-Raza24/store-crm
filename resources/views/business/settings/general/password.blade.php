@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.general.navbar')
                <hr class="m-0">
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settAccount" role="tabpanel"
                         aria-labelledby="settAccount">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                Please fill all required fields below
                            </div>
                        @endif
                        <div class="col-12">
                            @include("flash::message")
                        </div>
                        {!! Form::open(['url' => url()->current(), 'files' => true]) !!}
                        {!! method_field('PUT') !!}
                        {!! Form::hidden('business_id', $business->id) !!}

                        <div class="row">
                            <div class="col-12">
                                <h4 class="dark-one font-weight-700 mb-4">Change Password</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Old Password</label>
                                {!! Form::password('old_password',['class' => 'form-control order-edit-control '.($errors->has('old_password') ? 'danger-border' : '')]) !!}
                                @error('old_password')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> New Password</label>
                                {!! Form::password('new_password',['class' => 'form-control order-edit-control '.($errors->has('new_password') ? 'danger-border' : '')]) !!}
                                @error('new_password')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Confirm New Password</label>
                                {!! Form::password('new_password_confirmation',['class' => 'form-control order-edit-control '.($errors->has('new_password_confirmation') ? 'danger-border' : '')]) !!}
                                @error('new_password_confirmation')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <hr class="mt-5 mb-3">
                            <button class="btn-size btn-rounded btn-primary mr-3">
                                Update
                            </button>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
@endsection
