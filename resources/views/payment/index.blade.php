@extends('layouts.main')
@section('main')
    <div class="container table-responsive">
        <div class="payment-wrapper">
            <div class="payment-total">
                <p class="invoice">
                    <strong>{{ $order->no_inv }}</strong>
                    <span class="float-right">
                        {{ $sale_erp->sale->status }}
                    </span>
                    <br>{{ $order->cust_name }}
                </p>
                <h5>Total pembayaran</h5>
                <h4 id="total" style="font-weight: 700;color:red;">
                    {{ rupiah($sale_erp->payment_validation->transfer_amount) }}
                    <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#total')"></a>
                </h4>
                <div class="detail"><a href="javascript:void(0);" id="detail" data-toggle="modal" data-target="#paymentModal">Lihat detail</a></div>
                <div class="payment-note">
                    Mohon transfer sesuai nominal agar dapat tervalidasi otomatis <br>
                    Proses validasi membutuhkan waktu sekitar 5 menit
                </div>
            </div>
            @include('payment._status')
            @if (!in_array($sale_erp->sale->payment_status, ['Paid', 'Expired', 'Due']))
                @include('payment._daftar_bank')
            @endif
            <div class="payment-button">
                <a href="{{ route('track.order.w2p', ['invoice' => $order->no_inv]) }}" target="_blank" class="tracking">Tracking order</a>
                <div style="margin:0 50px 0 50px;">
                    <x-alert />
                    <x-auth.validate-error />
                </div>
                <a href="javascript:void(0);" class="tombol bukti-tf" data-toggle="modal" data-target="#uploadFile">Unggah
                    bukti pembayaran (optional)
                    <span data-toggle="tooltip" data-placement="top" title="Unggah bukti pembayaran untuk mempercepat proses validasi pembayaran" class="fad fa-question-circle"></span>
                </a>
                @if (!in_array($sale_erp->sale->payment_status, ['Paid', 'Expired', 'Due']) && $order->pickup == 'Indoprinting Durian')
                    <form action="{{ route('change.payment') }}" method="POST" id="myForm" class="mb-3 mt-5">
                        @csrf
                        <input type="hidden" name="id" value="{{ $order->id_order }}">
                        <input type="hidden" name="phone" value="{{ $order->cust_phone }}">
                        <input type="hidden" name="invoice" value="{{ $order->no_inv }}">
                        <input type="hidden" name="current" value="{{ $order->payment_method }}">
                        <a href="javascript:void(0);" class="metode" id="submit">Ganti metode pembayaran ke <strong>Cashier / Kasir</strong> ?</a>
                    </form>
                @endif
                <div class="@guest mt-5 @endguest">
                    <a href="/" class="tombol belanja">Belanja Lagi</a>
                    <a href='{{ route('download.invoice', ['invoice' => $order->no_inv, 'phone' => $order->cust_phone]) }}' class="tombol cek">Save Invoice</a>
                    @auth
                        <a href="/logout" class="tombol logout">Logout / keluar</a>
                    @endauth
                </div>
            </div>
        </div>
        @include('payment._detail_transaksi')
        @include('payment._upload_bukti_tf')
    </div>
    <script>
        $(document).ready(function() {
            $("#submit").click(function() {
                let r = confirm("Ganti metode pembayaran ?");
                if (r == true) {
                    $('#myForm').submit();
                } else {
                    console.log('CANCEL');
                }
            });

            let user = "<?= Auth()->id() ?>";
            if (!user) {
                alert("Harap simpan no invoice karena pelanggan melakukan order tanpa login");
            }
        });
    </script>
@endsection
