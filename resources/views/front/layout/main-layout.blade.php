<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <link rel="icon" href="{{ asset('front/img/favicon.png') }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('front/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/plugins/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/plugins/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/plugins/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/plugins/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/plugins/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

    <script src="{{ asset('front/js/plugins/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    @include('front.layout.header')
    <div class="cs_preloader cs_accent_color cs_white_bg">
        <div class="cs_preloader bg-white d-flex justify-content-center align-items-center">
            <div class="cs_preloader_in">
                <img src="{{ asset('front/img/favicon.png') }}" alt="Logo">
            </div>
        </div>
    </div>
    @yield('content')
    @include('front.layout.footer')
    <!-- Script -->
    <script src="{{ asset('front/js/plugins/isotope.pkg.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/jquery.slick.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/odometer.js') }}"></script>
    <script src="{{ asset('front/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>
</body>

</html>
