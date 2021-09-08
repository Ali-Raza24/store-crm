@extends('layouts.app')

@section('title','Forgot Password')

@section('content')
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-left login-left-full">
                <a href="javscript:void(0)" class="brand-logo brand-sm">
                    <img alt="" src="{{asset('images/yabee_logo_1.png')}}">
                </a>
            </div>
        </div>
        <div class="col-12 p-0">
            <div class="text-center ml-auto mr-auto col-lg-8 col-md-9 p-8 padding-h-30">
                <h2 class="login-title dark-one mb-3">Password Reset Successful </h2>
                <div class="reset-success primary-bg darkcolor mb-4">
                    <h3>Awesome, you’have successfully updated your password.</h3>
                </div>
                <p class="reset-text dark-three mb-3">You can use your new password to login to your account </p>
                <a class="btn btn-dark btn-rounded h-60 w-lg-50 w-75" href="{{route('login')}}"> Login </a>
            </div>
        </div>
    </div>
@endsection
