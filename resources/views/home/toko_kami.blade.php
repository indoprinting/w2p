@extends('layouts.main')
@section('main')
    <x-breadcrumb :title="$title" />
    <div class="container-fluid">
        <h4 class="title-store">{{ $title }}</h4>
        <div class="row store-wrapper">
            @foreach ($stores as $store)
                <div class="col-md-4 store">
                    <div style="text-align: center;">
                        <i class="fal fa-map-marker-alt"></i>
                    </div>
                    <div class="nama-kantor">
                        <a href="{{ $store->google_maps }}" target="_blank">
                            {{ $store->name }}
                        </a>
                    </div>
                    <hr>
                    <small>Alamat</small>
                    <div class="alamat">
                        <a href="{{ $store->google_maps }}" target="_blank">
                            {{ $store->address }}
                        </a>
                    </div>
                    <hr>
                    <small>No. Telepon</small>
                    <div class="telp">
                        <a href="tel:{{ $store->phone }}">{{ $store->phone }}</a>
                    </div>
                    <hr>
                    <small>E-mail</small>
                    <div class="telp">
                        {{ $store->email }}
                    </div>
                    <hr>
                    <small>Jam kerja</small>
                    <div class="jam">
                        {!! $store->working_hours !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
