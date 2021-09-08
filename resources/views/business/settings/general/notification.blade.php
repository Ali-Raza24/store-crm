@extends('layouts.business.setting-layout')

@section('title','Business Dashboard')

@section('header_heading','Setting')

{{--@section('header_subheading','54,5682 Orders Found')--}}

@section('content')
    <div class="row setting-wrapp">
        @include('business.settings.sidebar')
        <div class="col-lg-8">
            <div class="card-repeat setting-general pb-3 mt-4">
                @include('business.settings.general.navbar')
                <hr class="m-0">
                <div class="tab-content mt-5" id="nav-settingContent">
                    <div class="tab-pane fade show active" id="settNotificat" role="tabpanel"
                         aria-labelledby="settNotificat">
                        <?php
                        $notification = json_decode(setting('notification'));
                        $email = json_decode(setting('email'));
                        ?>
                        {!! Form::open(['url' => url()->current()]) !!}
                        {!! method_field('PUT') !!}
                        <h4 class="font-weight-700 dark-one mb-4">Notifications</h4>
                        @if(session()->has('notification'))
                            <div class="alert alert-success">
                                {!! session()->get('notification') !!}
                            </div>
                        @endif
                        <input type="hidden" name="notification">
                        <input type="hidden" name="email">
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[account_info_update]', 1, (!empty($notification->account_info_update) ? true : false), ['class' => 'custom-control-input', 'id' => 'note11']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note11">
                                <span class="pl-2">Account Information Update</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[invoice_generated]', 1, (!empty($notification->invoice_generated) ? true : false), ['class' => 'custom-control-input', 'id' => 'note12']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note12">
                                <span class="pl-2">Invoice Generate</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[role_create]', 1, (!empty($notification->role_create) ? true : false), ['class' => 'custom-control-input', 'id' => 'note13']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note13">
                                <span class="pl-2">Role Create</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[signin]', 1, (!empty($notification->signin) ? true : false), ['class' => 'custom-control-input', 'id' => 'note14']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note14">
                                <span class="pl-2">Sign In</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[user_create]', 1, (!empty($notification->user_create) ? true : false), ['class' => 'custom-control-input', 'id' => 'note15']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note15">
                                <span class="pl-2">User Create</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[order_placed]', 1, (!empty($notification->order_placed) ? true : false), ['class' => 'custom-control-input', 'id' => 'note16']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note16">
                                <span class="pl-2">Order Placed</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[role_update]', 1, (!empty($notification->role_update) ? true : false), ['class' => 'custom-control-input', 'id' => 'note17']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note17">
                                <span class="pl-2">Role Update</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[store_info_update]', 1, (!empty($notification->store_info_update) ? true : false), ['class' => 'custom-control-input', 'id' => 'note18']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note18">
                                <span class="pl-2">Store Information Update</span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[user_update]', 1, (!empty($notification->user_update) ? true : false), ['class' => 'custom-control-input', 'id' => 'note19']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note19">
                                <span class="pl-2">User Update</span>
                            </label>
                        </div>
                        {{--<div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[email_sms_template]', 1, (!empty($notification->email_sms_template) ? true : false), ['class' => 'custom-control-input', 'id' => 'note1']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note1">
                                <span class="pl-2">Emails and SMS Templates for Order confirmed</span>
                            </label>
                        </div>--}}
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[out_of_delivery]', 1, (!empty($notification->out_of_delivery) ? true : false), ['class' => 'custom-control-input', 'id' => 'note2']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note2">
                                <span class="pl-2"> Out for Delivery </span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[delivered]', 1, (!empty($notification->delivered) ? true : false), ['class' => 'custom-control-input', 'id' => 'note3']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note3">
                                <span class="pl-2"> Delivered </span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[refund]', 1, (!empty($notification->refund) ? true : false), ['class' => 'custom-control-input', 'id' => 'note4']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note4">
                                <span class="pl-2"> Refund </span>
                            </label>
                        </div>
                        <div class="form-group custom-checkbox mb-3">
                            {!! Form::checkbox('notification[cancelled]', 1, (!empty($notification->cancelled) ? true : false), ['class' => 'custom-control-input', 'id' => 'note5']) !!}
                            <label class="custom-control-label w-100 h-100 pl-4" for="note5">
                                <span class="pl-2"> Cancelled </span>
                            </label>
                        </div>
                        <hr class="mt-4 mb-4">
                        <h4 class="font-weight-700 dark-one mb-4">Emails</h4>
                        @if(session()->has('email'))
                            <div class="alert alert-success">
                                {!! session()->get('email') !!}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[account_creation]', 1, (!empty($email->account_creation) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail1']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail1">
                                        <span class="pl-2">Account Creation</span>
                                    </label>
                                </div>
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[account_verification]', 1, (!empty($email->account_verification) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail2']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail2">
                                        <span class="pl-2"> Account Verification </span>
                                    </label>
                                </div>
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[staff_invitation]', 1, (!empty($email->staff_invitation) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail3']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail3">
                                        <span class="pl-2"> Staff Invitation </span>
                                    </label>
                                </div>
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[invitation_accepted]', 1, (!empty($email->invitation_accepted) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail4']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail4">
                                        <span class="pl-2"> Invitation Accepted </span>
                                    </label>
                                </div>
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[all_exports]', 1, (!empty($email->all_exports) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail5']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail5">
                                        <span class="pl-2"> All Export </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[subscription]', 1, (!empty($email->subscription) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail6']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail6">
                                        <span class="pl-2">Subscription</span>
                                    </label>
                                </div>
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[payment_remainder]', 1, (!empty($email->payment_remainder) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail7']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail7">
                                        <span class="pl-2"> Payment Reminders </span>
                                    </label>
                                </div>
                                <div class="form-group custom-checkbox mb-3">
                                    {!! Form::checkbox('email[account_deactivation]', 1, (!empty($email->account_deactivation) ? true : false), ['class' => 'custom-control-input', 'id' => 'mail8']) !!}
                                    <label class="custom-control-label w-100 h-100 pl-4" for="mail8">
                                        <span class="pl-2"> Yabee Account Deactivation </span>
                                    </label>
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
