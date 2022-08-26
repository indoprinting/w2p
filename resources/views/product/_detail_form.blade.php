<form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data" id="formDetail">
    @csrf
    <input type="hidden" name="id" value="{{ $product->id_product }}">
    @if ($product->category == 17)
        <input type="hidden" name="no_design" value="1">
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Isian & Pilihan</th>
                <th width="20%">Harga</th>
            </tr>
        </thead>
        <tbody>
            @if ($product->category == 25)
                <tr>
                    <td>Cover</td>
                    <td class="nol">
                        <x-select name="atb1" id="atb1">
                            @foreach ($materials->material_name as $idm => $m_name)
                                {{ $m_value = "Cover,,$m_name,,{$materials->material_price[$idm]},,{$materials->material_code[$idm]},,{$materials->material_qty[$idm]},,{$materials->material_range[$idm]},,{$materials->material_category[$idm]}" }}
                                <option value="{{ $m_value }}" {{ old('atb1') == $m_value ? 'selected' : '' }}>
                                    {{ $m_name }}
                                </option>
                            @endforeach
                        </x-select>
                    </td>
                    <td class="bahan-price text-right"></td>
                </tr>
            @else
                <tr>
                    <td>Jenis Bahan</td>
                    <td class="nol">
                        <x-select name="atb1" id="atb1">
                            @foreach ($materials->material_name as $idm => $m_name)
                                {{ $m_value = "Material,,$m_name,,{$materials->material_price[$idm]},,{$materials->material_code[$idm]},,{$materials->material_qty[$idm]},,{$materials->material_range[$idm]},,{$materials->material_category[$idm]}" }}
                                <option value="{{ $m_value }}" {{ old('atb1') == $m_value ? 'selected' : '' }}>
                                    {{ $m_name }}
                                </option>
                            @endforeach
                        </x-select>
                    </td>
                    <td class="bahan-price text-right"></td>
                </tr>
            @endif
            @if (in_array($product->category, [11, 21, 26]) && $product->customize == 1)
                <tr>
                    <td>Panjang ({{ $product->unit_measure }})</td>
                    <td class="nol">
                        <x-input type="number" name="panjang" id="panjang" value="{{ old('panjang') }}" />
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lebar ({{ $product->unit_measure }})</td>
                    <td class="nol">
                        <x-input type="number" name="lebar" id="lebar" value="{{ old('lebar') }}" />
                    </td>
                    <td></td>
                </tr>
            @else
                @if (count($sizes->size) == 1)
                    <div class="d-none">
                        <x-select name="atb0" id="atb0">
                            {{ $v_size = "Ukuran,,{$sizes->size[0]},,{$sizes->price[0]}" }}
                            <option value="{{ $v_size }}" selected></option>
                        </x-select>
                    </div>
                @else
                    <tr>
                        <td>Ukuran</td>
                        <td class="nol">
                            <x-select name="atb0" id="atb0">
                                @foreach ($sizes->size as $ids => $size)
                                    {{ $v_size = "Ukuran,,$size,,{$sizes->price[$ids]}" }}
                                    <option value="{{ $v_size }}" {{ old('atb0') == $v_size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </x-select>
                        </td>
                        <td></td>
                    </tr>
                @endif
            @endif
            @foreach ($attributes->name as $id => $name)
                @php
                    $no = $loop->iteration + 1;
                @endphp
                @if ($name == 'Isi')
                    <tr>
                        <td><span id="atb-name{{ $no }}"><?= $name ?> (Jumlah Halaman)</span></td>
                        <td class="nol">
                            <div class="row">
                                <div class="col-sm-8">
                                    <x-select class="form-control atb" name="atb{{ $no }}" id="atb{{ $no }}" data-atb="{{ $no }}">
                                        @foreach ($attributes->value->value_name[$id] as $i => $vn)
                                            {{ $v_atb = "$name,,$vn,,{$attributes->value->value_price[$id][$i]},,{$attributes->value->value_code[$id][$i]},,{$attributes->value->value_qty[$id][$i]},,{$attributes->value->value_range[$id][$i]}" }}
                                            <option value="{{ $v_atb }}" {{ old("atb$no") == $v_atb ? 'selected' : '' }}>{{ $vn }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                                <div class="col-sm-4">
                                    <x-input type="number" name="qty_isi" id="qty_isi" min="1" value="1" oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');" placeholder="Jumlah" />
                                </div>
                            </div>
                        </td>
                        <td class="atb-text{{ $no }}  text-right"></td>
                    </tr>
                @else
                    <tr>
                        <td><span id="atb-name{{ $no }}"><?= $name ?></span></td>
                        <td class="nol">
                            <x-select class="form-control atb" name="atb{{ $no }}" id="atb{{ $no }}" data-atb="{{ $no }}">
                                @foreach ($attributes->value->value_name[$id] as $i => $vn)
                                    {{ $v_atb = "$name,,$vn,,{$attributes->value->value_price[$id][$i]},,{$attributes->value->value_code[$id][$i]},,{$attributes->value->value_qty[$id][$i]},,{$attributes->value->value_range[$id][$i]}" }}
                                    <option value="{{ $v_atb }}" {{ old("atb$no") == $v_atb ? 'selected' : '' }}>{{ $vn }}</option>
                                @endforeach
                            </x-select>
                        </td>
                        <td class="atb-text{{ $no }}  text-right"></td>
                    </tr>
                @endif
            @endforeach
            <input type="hidden" name="count" value="{{ 2 + count($attributes->name) }}">
            <tr>
                <td>Jumlah Order</td>
                <td class="nol">
                    <x-input type="number" name="qty" id="qty" min="{{ $product->min_order }}" value="{{ old('qty') ?? $product->min_order }}" oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');" />
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Total Harga</td>
                <td></td>
                <td class="total-harga text-right"></td>
            </tr>
        </tbody>
    </table>
    <!-- note -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" style="padding-bottom: 5px;"><b class="product-note">Catatan </b> </label>
        <div class="col-sm-12">
            <x-summernote class="form-control textarea" name="note" rows="4" id="product_note">{{ old('note') }}</x-summernote>
        </div>
    </div>
    @include('product._form_upload')
    <div>
        <label for="term" style="font-size: 14px;">
            <input type="checkbox" name="term" id="term" value="1" {{ old('term') == 1 ? 'checked' : '' }}>
            Saya telah meninjau dan menyetujui Design yang sudah saya kirim.
        </label>
    </div>
    <div>
        <a href="javascript:void(0);" class="btn btn-default tombol-beli submit"><i class="fas fa-shopping-cart"></i> BELI</a>
    </div>
</form>
