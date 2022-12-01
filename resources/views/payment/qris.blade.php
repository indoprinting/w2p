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
                <h4 id="total">{{ rupiah($sale_erp->sale->grand_total) }}</h4>
                <p class="detail"><a href="javascript:void(0);" data-toggle="modal" data-target="#paymentModal">Lihat detail</a></p>
            </div>
            @if (!in_array($sale_erp->sale->payment_status, ['Paid', 'Expired', 'Due']) && $qris->qris_status == 'unpaid')
                <div class="text-center">
                    <h4 class="mt-3 text-info">Scan QR Code untuk melakukan pembayaran</h4>
                    <h5 class="mt-3 text-danger">Mohon jangan menambah tips/biaya diluar total pembayaran</h5>
                    <a href="{{ route('download.qris', ['content' => urlencode($qris->qris_content), 'invoice' => $order->no_inv]) }}">
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ $qris->qris_content }}&choe=UTF-8" alt="" class="border">
                    </a>
                </div>
                <div class="text-center">
                    <form action="{{ route('check.qris') }}" method="POST">
                        @csrf
                        <input type="hidden" name="invoice" value="{{ $order->no_inv }}">
                        <button class="btn btn-info" id="check_qris" disabled>Check Status Pembayaran</button>
                        <div id="count_qris"></div>
                    </form>
                </div>
            @elseif ($sale_erp->sale->payment_status == 'Paid' || $qris->qris_status == 'paid')
                <h2 class="text-success text-center font-weight-bold"><i>LUNAS</i></h2>
            @elseif (in_array($sale_erp->sale->payment_status, ['Expired', 'Due']))
                <h2 class="text-danger text-center font-weight-bold"><i>PAYMENT EXPIRED</i></h2>
            @endif

            <div class="payment-button">
                <div style="margin:0 50px 0 50px;">
                    <x-alert />
                </div>
                <div class="mt-5">
                    <a href="javascript:void(0);" class="tombol bukti-tf" data-toggle="modal" data-target="#uploadFile">Unggah
                        bukti pembayaran (optional)
                        <span data-toggle="tooltip" data-placement="top" title="Unggah bukti pembayaran untuk mempercepat proses validasi pembayaran" class="fad fa-question-circle"></span>
                    </a>
                    <a href="{{ route('products') }}" class="tombol belanja">Belanja Lagi</a>
                    <a href="{{ route('download.invoice', ['invoice' => $order->no_inv, 'phone' => $order->cust_phone]) }}" class="tombol cek">Print Invoice</a>
                    <a href="{{ route('track.order.w2p', ['invoice' => $order->no_inv]) }}" target="_blank" class="tracking mt-3">Tracking order</a>
                </div>
                @auth
                    <a href="/logout" class="tombol logout">Logout / keluar</a>
                @endauth
            </div>
            <div class="px-2 mt-3">
                <div class="font-weight-bold">Cara pembayaran </div>
                <ul class="text-justify">
                    <li>Pembayaran menggunakan 1 perangkat :
                        <ul>
                            <li>Klik QR Code untuk mendownload qr code</li>
                            <li>Buka aplikasi e-money di smartphone</li>
                            <li>Pilih scan pembayaran kemudian pilih gambar dari galeri</li>
                            <li>Pilih qr code yang sudah didownload</li>
                        </ul>
                    </li>
                    <li>Pembayaran menggunakan 2 perangkat :
                        <ul>
                            <li>Buka aplikasi e-money di smartphone</li>
                            <li>Scan qrcode menggunakan smartphone</li>
                        </ul>
                    </li>
                    <li>Pastikan nominal di smartphone sama dengan nominal <strong>total pembayaran</strong></li>
                    <li>Klik tombol <i>Check Status Pembayaran</i> untuk memastikan pembayaran sudah masuk atau belum</li>
                    <li>Jika check status pembayaran memunculkan status gagal validasi silahkan tunggu 15 detik kemudian untuk mencoba kembali atau silahkan unggah bukti pembayaran pelanggan untuk divalidasi manual oleh tim online kami</li>
                </ul>
            </div>
        </div>
        @include('payment._detail_transaksi')
        @include('payment._upload_bukti_tf')

    </div>
    <script>
        $(document).ready(function() {

            var timeLeft = 15;
            var elem = document.getElementById('count_qris');

            var timerId = setInterval(countdown, 1000);

            function countdown() {
                if (timeLeft == 0) {
                    clearTimeout(timerId);
                    $('#count_qris').hide();
                } else {
                    elem.innerHTML = 'Mohon tunggu ' + timeLeft + ' detik';
                    timeLeft--;
                }
            }

            setTimeout(function() {
                $('#check_qris').prop('disabled', false);
            }, 15000);
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
