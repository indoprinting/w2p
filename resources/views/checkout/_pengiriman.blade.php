@auth
<div class="group-control row">
    <label class="col-sm-2 font-weight-bold">Pilih pengiriman</label>
    <div class="col-sm-10">
        <x-select2 name="pickup_method" id="pickup_method" required>
            <option value="Self-pickup">Ambil Sendiri ke Outlet</option>
            <option value="Delivery">Jasa Pengiriman</option>
        </x-select2>
        <small class="text-danger">@error('pickup_method') Harus pilih @enderror</small>
    </div>
</div>
@endauth
@guest
<input type="hidden" name="pickup_method" value="Self-pickup">
@endguest
<div class="group-control row mt-3 @auth alamat-outlet @endauth">
    <label class="col-sm-2 font-weight-bold">Alamat pickup</label>
    <div class="col-sm-10">
        <x-select2 name="alamat_outlet" id="alamat-outlet" data-placeholder="Pilih alamat pickup" required>
            <option value=""></option>
            @foreach ($outlets as $outlet)
            <option value="{{ $outlet->name }}">
                {{ $outlet->name.' ('.$outlet->address.')' }}
            </option>
            @endforeach
        </x-select2>
    </div>
</div>
