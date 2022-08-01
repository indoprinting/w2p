@extends('layouts.main')
@section('main')
    <main>
        <x-breadcrumb title="Checkout" />
        <section>
            <div class="container-fluid table-responsive">
                <x-alert />
                <x-auth.validate-error :errors="$errors" />
                <div class="cart-container">
                    <div>
                        <form method="POST" action="{{ route('payment') }}" id="form-checkout">
                            @csrf
                            <input type="hidden" name="berat" value="{{ $berat }}">
                            <input type="hidden" name="total" id="total_temp" value="{{ $total }}">
                            <div class="data-cust">
                                @include('checkout._data_pelanggan')
                                <div class="footer"></div>
                                @include('checkout._pengiriman')
                                @auth
                                    @include('checkout._kurir')
                                @endauth
                                <div class="footer"></div>
                                <div class="group-control row">
                                    <label class="col-sm-2 font-weight-bold">Metode pembayaran</label>
                                    <div class="col-sm-10">
                                        <select name="payment_method" id="payment_method" class="select2">
                                            <option value="Transfer">Transfer</option>
                                            <option value="Qris">Qris (Gopay, Ovo, ShopeePay, dll)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @include('cart._cart')
                    </div>
                    <div>
                        <div class="total-price">
                            <div class="text2">Ongkir <span class="float-right" id="harga_ongkir">Rp 0</span></div>
                            <div class="text2">Subtotal <span class="float-right">{{ rupiah($total) }}</span></div>
                        </div>
                        <div class="total-price">
                            <div class="text">Total Pembayaran</div>
                            <hr>
                            <div class="mobile">
                                <div class="price" id="biaya">{{ rupiah($total) }}</div>
                                <div class="payment">
                                    <a href="javascript:void(0);" id="submit"><i class="fal fa-credit-card"></i> Bayar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('assets/js/checkout.js') }}"></script>
@endsection
