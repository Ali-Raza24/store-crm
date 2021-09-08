<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="base_url" content="{{url('/')}}">
    <meta name='csrf-token' content='{{csrf_token()}}'>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('business_assets/css/reset.min.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/nouislider.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/order-edit.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/pdf-generator.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('business_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome/css/all.min.css')}}">

    @yield('css')

    <title>Yabee | @yield('title')</title>
</head>

<body>
<main class="wrapper wrapper-flexer">

    <section id="main-body" class="full-height h-auto">
        @if(session()->has('isAdmin'))
            <form action="{{route('admin-business-logout')}}" method="post" id="adminLogoutForm">
                @csrf
            </form>
            <a href="#" class="float btn-primary btn-rounded" onclick="adminLogout()">
                <span class="cursor-pointer fa fa-sign-out-alt fa-2x"></span>
            </a>
        @endif
        @yield('content')

    </section>

</main>


@yield('scripts')

@include('layouts.business.scripts')

<script>
    function adminLogout(){
      $('#adminLogoutForm').submit();
    }
</script>

</body>

</html>
