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

                        <div class="profile-change" id="profile">
                            <span>
                                @if(empty($business->profile))
                                    <img alt="" id="profileImage" class="profileImage"
                                         src="{{asset('images/profile-large.png')}}">
                                @else
                                    <img alt="" id="profileImage" class="profileImage"
                                         src="{{$business->profile}}"
                                         style="max-width: 504px; max-height:147px">
                                @endif
                            </span>
                        </div>
                            <div class="my-4">
                                <a href="javascript:void(0)" data-preview=".profileImage"
                                   data-url="{{route('general-setting-store-update')}}"
                                   data-form-data='@json(['business_id' => $business->id])'
                                   data-name="images[profile]"
                                   data-field-name="profile"
                                   data-width="512"
                                   data-height="512"
                                   data-url-json="{{route('update-cropped-image')}}"
                                   class="btn-gray-light btn-rounded font-weight-600 mb-2 my-5 p-2" data-toggle="fileupload">Change Your Photo</a>
                            </div>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="dark-one font-weight-700 mb-4">Login Information </h4>
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Name</label>
                                {!! Form::text('user[name]', auth()->user()->name, ['class' => 'form-control order-edit-control '.($errors->has('user.name') ? 'danger-border' : '')]) !!}
                                @error('user.name')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Email</label>
                                {!! Form::email('user[email]', auth()->user()->email, ['class' => 'form-control order-edit-control '.($errors->has('user.email') ? 'danger-border' : ''), 'readonly', 'disabled']) !!}
                                @error('user.email')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="dark-one font-weight-700 mb-4 mt-3"> Personal Information </h4>
                            </div>
                            {{--<div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Name</label>
                                {!! Form::text('owner_name', $business->owner_name, ['class' => 'form-control order-edit-control '.($errors->has('owner_name') ? 'danger-border' : '')]) !!}
                                @error('owner_name')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Email</label>
                                {!! Form::email('owner_email', $business->owner_email, ['class' => 'form-control order-edit-control '.($errors->has('owner_email') ? 'danger-border' : '')]) !!}
                                @error('owner_email')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>--}}
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Phone</label>
                                {!! Form::number('owner_phone', $business->owner_phone, ['class' => 'form-control order-edit-control '.($errors->has('owner_phone') ? 'danger-border' : '')]) !!}
                                @error('owner_phone')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Mobile</label>
                                {!! Form::number('owner_mobile', $business->owner_mobile, ['class' => 'form-control order-edit-control '.($errors->has('owner_mobile') ? 'danger-border' : '')])!!}
                                @error('owner_mobile')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="dark-one font-weight-700 mb-4 mt-3">Business Information </h4>
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Name</label>
                                {!! Form::text('name', $business->name, ['class' => 'form-control order-edit-control '.($errors->has('name') ? 'danger-border' : '')]) !!}
                                @error('name')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Email</label>
                                {!! Form::email('email',$business->email, ['class' => 'form-control order-edit-control '.($errors->has('email') ? 'danger-border' : '')]) !!}
                                @error('email')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Phone</label>
                                {!! Form::number('phone', $business->phone, ['class' => 'form-control order-edit-control '.($errors->has('phone') ? 'danger-border' : '')]) !!}
                                @error('phone')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Mobile</label>
                                {!! Form::tel('mobile', $business->mobile, ['class' => 'form-control order-edit-control '.($errors->has('mobile') ? 'danger-border' : '')]) !!}
                                @error('mobile')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Country</label>
                                <div class="form-icon">
                                    {!! Form::select('country_id', \App\Helpers\CommonHelper::countries(), $business->country_id, ['class' => 'order-edit-control form-control '.($errors->has('country_id') ? 'danger-border' : '')]) !!}
                                    @error('country_id')
                                    <div class="input-info danger-bg">
                                        <p>{{$message}}</p>
                                    </div>
                                    @enderror
                                    <span>
                                        <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> City</label>
                                <div class="form-icon">
                                    {!! Form::select('state_id', \App\Helpers\CommonHelper::states(), $business->state_id, ['class' => 'order-edit-control form-control '.($errors->has('state_id') ? 'danger-border' : '')]) !!}
                                    @error('state_id')
                                    <div class="input-info danger-bg">
                                        <p>{{$message}}</p>
                                    </div>
                                    @enderror
                                    <span>
                                        <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Address 1</label>
                                {!! Form::text('address_1', $business->address_1, ['class' => 'form-control order-edit-control '.($errors->has('address_1') ? 'danger-border' : '')]) !!}
                                @error('address_1')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2"> Address 2</label>
                                {!! Form::text('address_2', $business->address_2, ['class' => 'form-control order-edit-control '.($errors->has('address_2') ? 'danger-border' : '')]) !!}
                                @error('address_2')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                            @if(plan_has_permission(['bank-details']))

                        <hr class="mt-5 mb-3">
                        <!--                        <div class="form-group mb-0 text-right">
                                                    <hr class="mt-5 mb-3">
                                                    <button class="btn-size btn-rounded btn-primary mr-3">
                                                        Update
                                                    </button>
                                                </div>-->
                        {{--{!! Form::close()!!}
                        {!! Form::open(['url' => url()->current()]) !!}
                        {!! method_field('PUT') !!}--}}
                        {!! Form::hidden('bank[bank_id]', optional($bank)->id) !!}
                        <div class="row">
                            <h4 class="col-12 font-weight-700 dark-one mb-4">Bank Detail</h4>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="font-weight-600 dark-one mb-2">Bank Name</label>
                                <div class="form-icon">
                                    {!! Form::select('bank[bank_name]',
                                            \App\Helpers\CommonHelper::banksList(),
                                            optional($bank)->bank_name,
                                            ['class' => 'form-control order-edit-control '.($errors->has('bank.bank_name') ? 'danger-border' : '')]) !!}
                                    @error('bank.bank_name')
                                    <div class="input-info danger-bg">
                                        <p>The bank name field is required</p>
                                    </div>
                                    @enderror
                                    <span>
                                        <img alt="" src="{{asset('business_assets/images/angledown.png')}}">
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="font-weight-600 dark-one mb-2">Bank Branch</label>
                                <div class="form-icon">
                                    {!! Form::text('bank[branch]',
                                            optional($bank)->branch,
                                            ['class' => 'form-control order-edit-control '.($errors->has('bank.branch') ? 'danger-border' : '')]) !!}
                                    @error('bank.branch')
                                    <div class="input-info danger-bg">
                                        <p>The bank branch field is required</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="font-weight-600 dark-one mb-2">Account Holder Name</label>
                                <div class="form-icon">
                                    {!! Form::text('bank[account_title]',
                                            optional($bank)->account_title,
                                            ['class' => 'form-control order-edit-control '.($errors->has('bank.account_title') ? 'danger-border' : '')]) !!}
                                    @error('bank.account_title')
                                    <div class="input-info danger-bg">
                                        <p>The account holder name field is required</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="font-weight-600 dark-one mb-2">Account Number</label>
                                <div class="form-icon">
                                    {!! Form::text('bank[account_number]',
                                            optional($bank)->account_number,
                                            ['class' => 'form-control order-edit-control '.($errors->has('bank.account_number') ? 'danger-border' : '')]) !!}
                                    @error('bank.account_number')
                                    <div class="input-info danger-bg">
                                        <p>The account number field is required</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="font-weight-600 dark-one mb-2">IBAN Number</label>
                                <div class="form-icon">
                                    {!! Form::text('bank[iban]',
                                            optional($bank)->iban,
                                            ['class' => 'form-control order-edit-control '.($errors->has('bank.iban') ? 'danger-border' : '')]) !!}
                                    @error('bank.iban')
                                    <div class="input-info danger-bg">
                                        <p>The IBAN number field is required</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="font-weight-600 dark-one mb-2">Swift Code</label>
                                <div class="form-icon">
                                    {!! Form::text('bank[swift_code]',
                                            optional($bank)->swift_code,
                                            ['class' => 'form-control order-edit-control '.($errors->has('bank.swift_code') ? 'danger-border' : '')]) !!}
                                    @error('bank.swift_code')
                                    <div class="input-info danger-bg">
                                        <p>The swift code field is required</p>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                            @endif
                        <hr class="mt-5 mb-3">
                        <div class="row">
                            <h4 class="col-12 font-weight-700 dark-one mb-4">Social Information</h4>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Facebook</label>
                                {!! Form::text('social[facebook]', optional($social)->facebook,
                                ['class' => 'form-control order-edit-control '.($errors->has('social.facebook') ? 'danger-border' : '')]) !!}
                                @error('social.facebook')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Instagram</label>
                                {!! Form::text('social[instagram]', optional($social)->instagram,
                                ['class' => 'form-control order-edit-control '.($errors->has('social.instagram') ? 'danger-border' : '')]) !!}
                                @error('social.instagram')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Linked In</label>
                                {!! Form::text('social[linkedin]', optional($social)->linkedin,
                                ['class' => 'form-control order-edit-control '.($errors->has('social.linkedin') ? 'danger-border' : '')]) !!}
                                @error('social.linkedin')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Twitter</label>
                                {!! Form::text('social[twitter]', optional($social)->twitter,
                                ['class' => 'form-control order-edit-control '.($errors->has('social.twitter') ? 'danger-border' : '')]) !!}
                                @error('social.twitter')
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
