@extends('layouts.auth')
@section('auth-page')
    <form class="form" method="POST" action="{{ route('login') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <input type="hidden" name="link" value="login">
        <div class="wrap-input">
            <i class="far fa-user">
            </i>
            <span class="label-input">No. telp</span>
            <input class="input" type="text" name="phone" value="{{ old('phone') }}" autocomplete="phone-off" autofocus>
            <span class="focus-input"></span>
        </div>

        <div class="wrap-input">
            <i class="far fa-lock"></i><span class="label-input">Password</span>
            <input class="input password" type="password" name="password" autocomplete="chrome-off">
            <span class="show-password far fa-eye"></span>
            <span class="focus-input"></span>
        </div>

        <div class=" forget">
            <a href="{{ route('verifikasi.akun') }}">Lupa password ?</a>
        </div>
        <a href="javascript:void(0);" id="submit">
            <div class="button-login">
                <span>
                    Login
                </span>
            </div>
        </a>
    </form>
    <div class="dengan">atau</div>
    <a href="{{ route('google.login') }}">
        <div class="google">
            <img src="/assets/images/logo/logo-google.png" alt="">
            <div class="text">Masuk dengan google</div>
        </div>
    </a>
    <a href="{{ route('checkout.tanpalogin') }}">
        <div class="login">Checkout tanpa login</div>
    </a>
@endsection
