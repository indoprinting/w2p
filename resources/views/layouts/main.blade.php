<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>IDP | {{ $title ?? 'Cetak Xpres, Harga Ngepres, Kualitas The Best' }}</title>
    <meta content="indoprinting" name="description">
    <meta content="indoprinting" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/images/logo/favicon.png') }}" rel="icon">
    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/summernote/summernote.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/myStyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/input-file.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pagination.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/gmaps.css') }}">

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/input-file.js') }}"></script>
</head>

<body>
    @include('layouts.header')
    <div class="content">
        @yield('main')
    </div>
    @include('layouts.footer_mobile')
    @include('layouts.footer')
    <!-- Vendor JS Files -->
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/summernote/summernote.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/myJs.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    @include('layouts.tawk_to')
</body>

</html>
