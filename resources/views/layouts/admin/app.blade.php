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
    <link rel="stylesheet" href="{{asset('admin_assets/css/reset.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/customer.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/nouislider.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/order-edit.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/pdf-generator.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome/css/all.min.css')}}">

    @yield('stylesheet')

    @yield('css')

    <title>Yabee | @yield('title', "Business Dashboard")</title>
</head>

<body>
<!--Loader-->
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
<!-- Loader end -->
<main class="wrapper grey-one">

    @include('layouts.admin.header')

    <section id="main-body" class="grey-one">

        @include('layouts.admin.sidebar')

        <div class="container-fluid">

            @yield('content')

        </div>

    </section>

    @include('layouts.admin.footer')
</main>

@yield('extras')

@yield('scripts')
@include('layouts.admin.scripts')


</body>

</html>
