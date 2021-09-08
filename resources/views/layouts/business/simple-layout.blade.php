<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="base_url" content="{{url('/')}}">
    <meta name='csrf-token' content='{{csrf_token()}}'>
    <link rel="icon" href="{{asset('images/favicon.gif')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/reset.min.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/customer.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/nouislider.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/order-edit.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/pdf-generator.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('business_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset_timestamp('plugins/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{asset('plugins/uploader/image-uploader.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-blueimp/css/jquery.fileupload.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-blueimp/css/jquery.fileupload-ui.css')}}">
    @yield('stylesheet')

    <title>Yabee | @yield('title', "Business Dashboard")</title>
</head>

<body>
@yield('css')
<div id="loader">
    <div class="loader">
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__bar"></div>
        <div class="loader__ball"></div>
    </div>
</div>

<main class="wrapper grey-one">

    @include('layouts.business.simple-header')

    <section id="main-body" class="grey-one">
        @if(session()->has('isAdmin'))
            <form action="{{route('admin-business-logout')}}" method="post" id="adminLogoutForm">
                @csrf
            </form>
            <a href="#" class="float btn-primary btn-rounded" onclick="adminLogout()">
                <span class="cursor-pointer fa fa-sign-out-alt fa-2x"></span>
            </a>
        @endif

        <div class="container-fluid">

        @yield('content')

        </div>

    </section>

    @include('layouts.business.footer')
    <x-image-uploader id="image-upload-modal"></x-image-uploader>
</main>

@yield('extras')

@yield('scripts')
@include('layouts.business.scripts')


</body>

</html>
