<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>IDP | {{ $title ?? 'Cetak Expres, Harga Ngepres, Kualitas The Best' }}</title>
    <meta content="indoprinting" name="description">
    <meta content="indoprinting" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="{{ asset('assets/images/logo/favicon.png') }}" rel="icon">
    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}">
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
        <main>
            <x-breadcrumb title="{{ $title ?? 'Profilku' }}" />
            <div class="container-fluid">
                <section class="content">
                    <div class="row">
                        <div class="col-md-2">
                            {{-- <a href="javascript:void(0);" id="lihat_profile" style="display: none;">Pengaturan Akun</a> --}}
                            <div class="card shadow profile-cust mb-3">
                                <div class="card-body">
                                    <p style="font-size: 18px;"><strong>Profilku</strong></p>
                                    <ul class="list-profile">
                                        <li><a href="{{ route('profile') }}" class="icon-profile"><span class="icon-profile fab fa-shopify"></span> Daftar Belanja</a></li>
                                        <li><a href="{{ route('design.studio') }}" class="icon-profile"><span class="icon-profile fab fa-users"></span> Design Studio</a></li>
                                        <li><a href="{{ route('edit.profile') }}" class="icon-profile"><span class="icon-profile fas fa-user"></span> Pengaturan Akun</a></li>
                                        <li><a href="{{ route('edit.address') }}" class="icon-profile2"><span class="icon-profile2 fas fa-house-user"></span> Alamat</a></li>
                                        <li><a href="{{ route('edit.password') }}" class="icon-profile2"><span class="icon-profile2 fas fa-key"></span> Ubah Password</a></li>
                                        <li><a href="{{ route('checkout') }}" class="icon-profile"><span class="icon-profile fas fa-shopping-cart"></span> Checkout</a></li>
                                        <li><a href="{{ route('queue.online') }}" class="icon-profile"><span class="icon-profile fas fa-ticket-alt"></span> Registrasi Pelayanan Outlet</a></li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            @yield('profile')
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    @include('layouts.footer_mobile')
    @include('layouts.footer')
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/myJs.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script>
        $(document).ready(function() {
            let url = document.URL;
            $(".icon-profile")
                .filter(function() {
                    return this.href == url;
                }).css('color', '#e96c56');

            $(".icon-profile2")
                .filter(function() {
                    return this.href == url;
                }).css('color', '#e96c56');
        });
    </script>
    @include('layouts.tawk_to')
</body>

</html>
