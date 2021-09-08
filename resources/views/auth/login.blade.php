@extends('layouts.app')

@section('title','Login')

@section('content')
    <div id="auth">
        <login url="{{api_url('login')}}" send-email-link="{{api_url('send_email_link')}}"></login>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('admin_assets/js/select2.min.js')}}"></script>
@endsection
