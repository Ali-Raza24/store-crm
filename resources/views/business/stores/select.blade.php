@extends('layouts.business.simple-layout')

@section('title','Select Store')

@section('content')
    <div class="row m-0 justify-content-center">
        <div class="col-12 p-0">
            <div class="form-area d-flex align-items-center justify-content-center h-100">
                <form class="outh-form">
                    <div class="form-group radius-group single-input text-center p-8 padding-h-30">
                        @include('flash::message')
                        <h2 class="login-title dark-one mb-2">Welcome to Store</h2>
                        <h3 class="dark-one">
                            Please select a store to continue
                        </h3>
                        <div class="form-icon mt-5 mb-4">
                            <select class="form-control" name="store-select" id="select-store">
                                <option selected disabled> Select Store</option>
                                @foreach($stores as $slug => $store)
                                    <option value="{{$slug}}">{{$store}}</option>
                                @endforeach
                            </select>
                            <span> <img alt="" src="{{asset('business_assets/images/angledown1.png')}}"> </span>
                        </div>
                        <h4 class="text-center" id="or-text">
                            <span class="d-inline-block darkcolor mt-2">OR</span>
                        </h4>

                        <!-- for form submit -->
                        <!-- <button type="button" class="btn btn-primary btn-rounded w-100 mt-3">
                            Create New Store
                        </button> -->
                        <!-- for demo Link -->
                        <a href="{{route('store-create')}}" type="button" id="create-store-btn"
                           class="btn btn-primary btn-rounded w-100 mt-3">
                            Create New Store
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('layouts.jquery')
    <script>
      $('select[name="store-select"]').on('change', function() {
        window.location.href = "{{route('change-store')}}/"+$(this).val();
        $('#create-store-btn').hide()
        $('#or-text').hide()
      });
    </script>
@endsection
