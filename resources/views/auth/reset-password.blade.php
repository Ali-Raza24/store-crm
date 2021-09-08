@extends('layouts.app')

@section('title','Forgot Password')

@section('content')
    <div id="auth">
        <reset-password url="{{api_url('reset_password')}}"></reset-password>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/app.js')}}"> </script>
@endsection
