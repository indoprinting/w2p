@extends('layouts.main')
@section('main')
    <x-breadcrumb :title="$title" />
    <div class="wrapper-pl" style="min-height: 200px;">
        <h2>{{ $title }}</h2>
        <div class="underline"></div>
        <x-alert />
        <div class="mx-sm-5">
            <form action="{{ route('get.queue') }}" method="POST" class="mb-5">
                @csrf
                <div class="row my-2">
                    <label for="" class="col-md-4">Pilih Outlet</label>
                    <div class="col-md-8">
                        <x-select2 name="outlet" data-placeholder="Pilih Outlet" required>
                            <option value=""></option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->warehouse }}">{{ $outlet->name }}</option>
                            @endforeach
                        </x-select2>
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-md-4">Pilih Pelayanan</label>
                    <div class="col-md-8">
                        <x-select2 name="service" data-placeholder="pilih pelayanan" required>
                            <option value=""></option>
                            <option value="siap_cetak">Siap Cetak</option>
                            <option value="edit_design">Edit Design</option>
                        </x-select2>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div>History</div>
            <div class="table-responsive ">
                <table class="table table-bordered text-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>No. Antrian</th>
                            <th>Service</th>
                            <th>ETS ( Estimated Time Service)</th>
                            <th>Outlet</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($queues as $queue)
                            <tr class="@if ($loop->first) text-bold @endif">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ dateID2($queue->created_at) }}</td>
                                <td>{{ $queue->no_antrian }}</td>
                                <td>{{ $queue->service }}</td>
                                <td>{{ dateTimeID2($queue->ets) }}</td>
                                <td>Indoprinting {{ $queue->outlet }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <a href="javascript:;" id="lihat_gambar">Lihat Cara Registrasi</a>
            <img src="{{ asset('images/admin/cara_register.jpg') }}" alt="" width="100%" id="gambar_register">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#gambar_register").hide();
            $("#lihat_gambar").on('click', function() {
                $("#gambar_register").slideToggle('fast');
            });
        });
    </script>
@endsection
