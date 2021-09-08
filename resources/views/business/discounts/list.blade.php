@extends('layouts.business.app')

@section('title','All Discount')

@section('header_heading', "All Discount")

@section("header_subheading", "Overview")

@section('content')
    <div class="mt-3">
        @include('flash::message')
    </div>
    @include('business.discounts.navbar')
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="AllDiscount" role="tabpanel" aria-labelledby="AllDiscount">
            @include('business.discounts.table')
        </div>
    </div>
@endsection
@include('business.discounts.extra')
