@extends('layouts.admin.app')
@section('title', 'Areas')
@section('heading', 'Areas')

@section('css')
    <style>
        .pac-container {
            top: 340px !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">
                    Manage Areas
                </h2>
                <h4 class="tagline dark-one font-weight-400">
                    Overview
                </h4>
            </div>
        </div>
    </div>
    <div class="mt-3">
        @include('flash::message')
    </div>
    @include('admin.areas.navbar')
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="Allarea" role="tabpanel" aria-labelledby="Allarea-tab">
            @include('admin.areas.table')
        </div>
    </div>
@endsection
@include('admin.areas.extra')
