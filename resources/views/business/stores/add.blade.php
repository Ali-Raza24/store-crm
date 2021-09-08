@extends('layouts.business.simple-layout')

@section('title','Create Store')

@section('content')
    @include('flash::message')
    <div id='stores'>
        <store-create @if($store > 0) business_store_url="{{$url}}" @endif
        save_url='{{api_url('store-add')}}' industry_url='{{api_url('industries')}}' states_url="{{api_url('states')}}"
                      app_url="{{config('urls.store_url')}}">
        </store-create>
    </div>
@endsection
@section('scripts')
    <script src='{{asset_timestamp('js/stores.js')}}'></script>
@endsection

