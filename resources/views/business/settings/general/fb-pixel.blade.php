@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('css')
    <style>.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before{
            color: #fff;
            background-color: transparent;
            border-color: #b3d7ff
        }</style>
@endsection

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.general.navbar')
                <hr class="m-0">
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settCheckout" role="tabpanel"
                         aria-labelledby="settCheckout">
                        <div class="col-12">
                            @include('flash::message')
                        </div>
                      {!! Form::open(['url' => url()->current()]) !!}
                        {!! method_field('PUT') !!}
                            <div class="row">
                                <h4 class="col-12 font-weight-700 dark-one mb-4">
                                    FB Pixel
                                </h4>
                                <div class="col-md-5 col-sm-6">
                                    <div class="form-group custom-checkbox mb-3">
                                        <label for="">FB Pixel Script</label>
                                        {!! Form::textarea('pixel[script]', check_setting('pixel','script'), ['class' => 'form-control order-edit-control']) !!}
                                    </div>
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
