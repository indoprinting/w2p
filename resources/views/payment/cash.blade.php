@extends('layouts.main')
@section('main')
    <div class="container table-responsive">
        <div class="payment-wrapper">
            <div class="payment-total">
                <p class="invoice">{{ $order->no_inv }}<span class="float-right">{{ $sale_erp->sale->status }}</span></p>
                <h5>Total pembayaran</h5>
                <h4 id="total">{{ rupiah($sale_erp->sale->grand_total) }}</h4>
                <p class="detail"><a href="javascript:void(0);" data-toggle="modal" data-target="#paymentModal">Lihat detail</a></p>
                <p class="detail"><a href="{{ route('track.order.w2p', ['invoice' => $order->no_inv]) }}" target="_blank">Tracking order</a></p>

            </div>
            @include('payment._status')
            <div class="payment-note" style="margin-bottom: 30px;padding:0 10px">
                Terima kasih telah melakukan transaksi, silahkan menunggu untuk dipanggil oleh kasir
            </div>
            <div class="payment-button">
                @if (!in_array($sale_erp->sale->payment_status, ['Paid', 'Expired', 'Due']) && $order->pickup == 'Indoprinting Durian')
                    <form action="{{ route('change.payment') }}" method="POST" id="myForm" style="margin-bottom: 20px;margin-top:60px;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $order->id_order }}">
                        <input type="hidden" name="phone" value="{{ $order->cust_phone }}">
                        <input type="hidden" name="invoice" value="{{ $order->no_inv }}">
                        <input type="hidden" name="current" value="{{ $order->payment_method }}">
                        <a href="javascript:void(0);" class="metode" id="submit">Ganti metode pembayaran ke <b>Transfer</b> ?</a>
                    </form>
                @endif
                <div style="margin:0 50px 0 50px;">
                    <x-alert />
                </div>
                <a href="{{ route('products') }}" class="tombol belanja">Belanja Lagi</a>
                <a href="{{ route('download.invoice', ['invoice' => $order->no_inv, 'phone' => $order->cust_phone]) }}" class="tombol cek">Print Invoice</a>
                @auth
                    <a href="/logout" class="tombol logout">Logout / keluar</a>
                @endauth
            </div>
        </div>
        @include('payment._detail_transaksi')

    </div>
    <script>
        $(document).ready(function() {
            let user = "<?= Auth()->id() ?>";
            console.log(user);
            if (!user) {
                alert("Harap simpan no invoice karena pelanggan melakukan order tanpa login");
            }
            $("#submit").click(function() {
                let r = confirm("Ganti metode pembayaran ?");
                if (r == true) {
                    $('#myForm').submit();
                } else {
                    console.log('CANCEL');
                }
            });
        });
    </script>

@endsection
