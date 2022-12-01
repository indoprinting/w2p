<h5>Informasi pelanggan @auth <a href="{{ route('edit.profile') }}" class="fal fa-user-edit icon"></a> @endauth</h5>
@auth
    <div class="cust-info">
        <div style="font-weight: 600;">
            {!! Auth()->user()->name ?? '<a href="edit-profile" class="text-danger">Nama harus diisi</a>' !!}
        </div>
        <div>
            {!! Auth()->user()->phone ?? '<a href="edit-profile" class="text-danger">Nomor telepon harus diisi</a>' !!}
            /
            {!! Auth()->user()->email ?? '<a href="edit-profile" class="text-danger">E-mail belum diisi</a>' !!}
        </div>
        <div>
            {!! $alamat->address ?? '<a href="edit-address" class="text-danger">Alamat belum diisi</a>' !!}
        </div>
    </div>
@endauth
@guest
    <input type="hidden" name="tanpa_login" value="1">
    <div class="cust-info">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <x-input type="text" name="name" value="{{ old('name') }}" required autocomplete="name-off" />
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No. Telp</label>
                    <div class="col-sm-10">
                        <x-input type="text" name="phone" value="{{ old('phone') }}" required autocomplete="phone-off" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endguest
