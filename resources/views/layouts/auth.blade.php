<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>IDP | {{ $title }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--===============================================================================================-->
    <link href="{{ asset('assets/images/logo/favicon.png') }}" rel="icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/auth/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/auth/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <!--===============================================================================================-->
</head>

<body>
    <main class="limiter">
        <div class="container-auth m-t-150">
            <img src="/assets/images/promotion/{{ $promo }}" alt="" class="logo-2">
            <div class="row">
                <div class="promotion">
                    <a href="/"><img src="/assets/images/promotion/{{ $promo }}" alt="" class="mw-100"></a>
                </div>
                <div class="wrap-auth" id="auth-dengan-login">
                    <div class="p-l-40 p-r-40 p-t-10 p-b-10">
                        <div class="text-center pt-3">
                            <a href="/">
                                <img src="{{ asset('assets/images/logo/logo-idp.png') }}" alt="" width="250px">
                            </a>
                        </div>
                        <x-alert />
                        <x-auth.validate-error :errors="$errors" />
                        @yield('auth-page')
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="copyright">&copy; Copyright <strong><span>indoprinting</span></strong> 2021</div>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".show-password").click(function() {
                let x = $('.password').attr('type');
                if (x == 'password') {
                    $('.password').attr('type', 'text');
                } else {
                    $('.password').attr('type', 'password');

                }
            });
            $('#submit').on('click', function() {
                $('#myForm').submit();
            });
        });
    </script>

</body>

</html>
