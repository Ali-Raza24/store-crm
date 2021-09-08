@extends('layouts.admin.app')

@section('title', 'Company Information')
@section('heading', 'Company Information')

@section('content')
    <div class="row">
        <div class="col">
            <div class="header-lefter mobile-title desktop-hide mt-4">
                <h2 class="dark-one font-weight-700">Settings</h2>
                <h4 class="tagline dark-one font-weight-400">Quick Overview</h4>
            </div>
        </div>
    </div>

    <div class="row setting-wrapp">
        <div class="col-lg-4">
            @include('admin.settings.sidebar')
        </div>
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('admin.settings.general.navbar')
                <hr class="m-0" />
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settStore" role="tabpanel" aria-labelledby="settStore">
                        <div class="col-12">
                            @include('flash::message')
                        </div>
                        {!! Form::open(['route' => 'admin-company-page-store']) !!}
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2">Name</label>
                                {!! Form::text('name', $user->name, ['class' => 'form-control order-edit-control '.($errors->has('name') ? 'danger-border' : null)]) !!}
                                @error('name')
                                    <div class="input-info danger-bg">
                                        <p>{{$message}}</p>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2">Email</label>
                                {!! Form::email('email', $user->email, ['class' => 'form-control order-edit-control '.($errors->has('email') ? 'danger-border' : null), 'disabled']) !!}
                                @error('email')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Mobile</label>
                                {!! Form::number('details[mobile]', optional($user->details)->mobile, ['class' => 'form-control order-edit-control '.($errors->has('details.mobile') ? 'danger-border' : null)]) !!}
                                @error('details.mobile')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Phone</label>
                                {!! Form::text('details[phone]', optional($user->details)->phone, ['class' => 'form-control order-edit-control '.($errors->has('details.phone') ? 'danger-border' : null)]) !!}
                                @error('details.phone')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label class="font-weight-600 dark-one">About</label>
                                {!! Form::textarea('details[about]', optional($user->details)->about, ['class' => 'form-control order-edit-control '.($errors->has('details.about]') ? 'danger-border' : null)]) !!}
                                @error('details.about')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Facebook</label>
                                {!! Form::text('social[facebook]', optional($setting)->facebook, ['class' => 'form-control order-edit-control '.($errors->has('social.facebook') ? 'danger-border' : null)]) !!}
                                @error('social.facebook')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Instagram</label>
                                {!! Form::text('social[instagram]', optional($setting)->instagram, ['class' => 'form-control order-edit-control '.($errors->has('social.instagram') ? 'danger-border' : null)]) !!}
                                @error('social.instagram')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Linked In</label>
                                {!! Form::text('social[linkedin]', optional($setting)->linkdin, ['class' => 'form-control order-edit-control '.($errors->has('social.linkedin') ? 'danger-border' : null)]) !!}
                                @error('social.linkedin')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Twitter</label>
                                {!! Form::text('social[twitter]', optional($setting)->twitter, ['class' => 'form-control order-edit-control '.($errors->has('social.twitter') ? 'danger-border' : null)]) !!}
                                @error('social.twitter')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">Country</label>
                                <div class="form-icon">
                                    {!! Form::select('details[country_id]',\App\Helpers\CommonHelper::countries(), optional($user->details)->country_id, ['class' => 'order-edit-control form-control '.($errors->has('details.country_id') ? 'danger-border' : null)]) !!}
                                    @error('details.country_id')
                                    <div class="input-info danger-bg">
                                        <p>{{$message}}</p>
                                    </div>
                                    @enderror
                                    <span><img src="{{asset('admin_assets/images/angledown.png')}}" alt=""></span>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group mb-3">
                                <label class="font-weight-600 dark-one">City</label>
                                <div class="form-icon">
                                    {!! Form::select('details[state_id]',\App\Helpers\CommonHelper::states(), optional($user->details)->state_id, ['class' => 'order-edit-control form-control '.($errors->has('details.state_id') ? 'danger-border' : null)]) !!}
                                    @error('details.state_id')
                                    <div class="input-info danger-bg">
                                        <p>{{$message}}</p>
                                    </div>
                                    @enderror
                                    <span><img src="{{asset('admin_assets/images/angledown.png')}}" alt=""></span>
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label class="font-weight-600 dark-one mb-2">Address</label>
                                {!! Form::text('details[address]', optional($user->details)->address, ['class' => 'form-control order-edit-control '.($errors->has('details.address') ? 'danger-border' : null)]) !!}
                                @error('details.address')
                                <div class="input-info danger-bg">
                                    <p>{{$message}}</p>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <hr class="mt-5 mb-3" />
                            <button class="btn-size btn-rounded btn-primary mr-3">Update</button>
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
    <script>
      //show Discount Edit view
      @if(!empty($showTestimonialEdittab) || $errors->any())
      $('body').toggleClass('customer-modal');
      @endif
      function uploadDialog () {
        $('#imgupload').trigger('click');
      }
    </script>
@endsection
