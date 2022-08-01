@extends('layouts.auth')
@section('auth-page')
    <div class="dengan mb-5">Check pesan whatsapp pelanggan untuk mendapatkan <strong>PIN</strong></div>
    <form class="form" method="POST" action="{{ route('reset.password') }}" enctype="multipart/form-data" id="myForm">
        @csrf
        <input type="hidden" name="phone" value="{{ $phone }}">
        <div class="wrap-input">
            <i class="far fa-cog"></i> <span class="label-input">PIN</span>
            <x-input class="input" type="text" name="pin" value="{{ old('pin') }}" autofocus />
            <span class="focus-input"></span>
        </div>

        <div class="wrap-input">
            <i class="far fa-lock"></i><span class="label-input">Password</span>
            <x-input class="input password" type="password" name="password" autocomplete="chrome-off" />
            <span class="show-password far fa-eye"></span>
            <span class="focus-input"></span>
        </div>

        <a href="javascript:void(0);" id="submit">
            <div class="button-login">
                <span>
                    Submit
                </span>
            </div>
        </a>
    </form>
@endsection
