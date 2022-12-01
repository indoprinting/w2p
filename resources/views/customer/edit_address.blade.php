@extends('layouts.profile')
@section('profile')
@php
if (isset($address->coordinate)) :
$coord = explode(',', $address->coordinate);
else :
$coord[0] = "";
$coord[1] = "";
endif;
@endphp
<div class="card shadow p-3">
    <x-alert />
    <x-auth.validate-error />
    <form action="{{ route('save.address') }}" method="POST" class="form-horizontal formAddProduct">
        @csrf
        <input type="hidden" name="id" value="{{ $address?->id }}">
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <x-textarea name="address" id="address" rows="2" style="width: 100%;">
                    {{ old('address') ?? $address?->address }}
                </x-textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">RT/RW</label>
            <div class="col-sm-10">
                <x-input type="text" name="rt_rw" value="{{ old('rt_rw') ?? $address?->rt_rw }}" placeholder="Contoh: 01/05" />
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Provinsi</label>
            <div class="col-sm-10">
                <x-select2 name="province" id="province">
                    @if (isset($address))
                    <option value="{{ $address->province_id }}" selected>{{ $address->province->province_name }}</option>
                    @else
                    <option value="" selected hidden disabled>Pilih Provinsi</option>
                    @endif
                    @foreach ($provinces as $province)
                    <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                    @endforeach
                </x-select2>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Kota/Kabupaten</label>
            <div class="col-sm-10">
                <x-select2 name="city" id="city" disabled>
                    @isset($address)
                    <option value="{{ $address->city->city_id }}" selected>{{ $address->city->city_name }}</option>
                    @endisset
                </x-select2>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Kecamatan</label>
            <div class="col-sm-10">
                <x-select2 name="suburb" id="suburb" disabled>
                    @isset($address)
                    <option value="{{ $address->suburb->suburb_id }}" selected>{{ $address->suburb->suburb_name }}</option>
                    @endisset
                </x-select2>
            </div>
        </div>

        <!-- gmaps -->
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label mt-5">Koordinate google maps (Optional) <br>
                <small class="text-info">Isi alamat google maps untuk menggunakan jasa GOSEND</small>
            </label>
            <div class="col-sm-10 mt-5">
                <input id="pac-input" class="controls" type="text" placeholder="Cari alamat" />
                <div id="map"></div>
                <input type="text" id="lat" name="lat" value="{{ old('lat') ?? $coord[0] }}" readonly>
                <input type="text" id="lng" name="lng" value="{{ old('lng') ?? $coord[1] }}" readonly>
                <a href="javascript:;" class="ml-3 text-danger text-large" id="current-location" onclick="getLocation()"><i class="fas fa-map-marker-alt"></i></a href=" javascript:;">
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-info" type="submit">Update Alamat</button>
        </div>
    </form>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP-hGcct-nQS50RHHdXjwXgNxi71jRaU8&callback=initAutocomplete&libraries=places" async></script>
<script>
    window.lat_php = "<?= $coord[0] ? $coord[0] : -7.065076535253742 ?>";
    window.long_php = "<?= $coord[0] ? $coord[1] : 110.42755767388537 ?>";
</script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="{{ asset('assets/js/edit_address.js') }}"></script>

@endsection