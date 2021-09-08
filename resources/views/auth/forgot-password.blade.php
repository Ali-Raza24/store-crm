@extends('layouts.app')

@section('title','Forgot Password')

@section('content')
    <div id="auth">
        <forgot-password url="{{api_url('forgot_password')}}"></forgot-password>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection
