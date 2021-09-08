@extends('layouts.app')
@section('content')
    <style>
        .busi_build{
            background: #fafafa !important;
            height: 100vh;
        }
        .busi_build .form-control::placeholder{
            color: grey;
        }
        .busi_build .form-control{
            color: black;
        }
    </style>
    <div id="auth">
        <register url="{{api_url('register')}}"></register>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection