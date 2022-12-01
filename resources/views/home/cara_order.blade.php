@extends('layouts.main')
@section('main')
<x-breadcrumb title="Cara Order" />
<div class="wrapper">
    <h2>Cara order</h2>
    <div class="underline"></div>
    <div class="img-purchase">
        <img src="{{ asset('assets/images/admin/cara-order.png') }}" class="mw-100">
    </div>
    <div class="detail-flow">
        <ol>
            <li>Pilih produk, kemudian pilih atribut produk seperti : Bahan, Ukuran, Finishing, dll.</li>
            <li>Unggah desain yang sudah jadi sesuai dengan pedoman unggah desain. Kemudian silahkan baca <b>Syarat &
                    ketentuan</b> dan centang <b>"Saya setuju dengan persyaratan"</b>.</li>
            <li>Tambahkan produk ke dalam keranjang, jika ingin menambah produk bisa diulangi langkah 1-2.</li>
            <li>Untuk melanjutkan proses checkout silahkan login atau bisa order tanpa login.</li>
            <li>Klik <b>Keranjang</b> untuk melanjutkan proses checkout.</li>
            <li>Pilih Lokasi Pengambilan / Delivery.</li>
            <li>Pastikan data pelanggan sudah benar dan kemudian klik <b>Bayar</b>.</li>
            <li>Silahkan lakukan pembayaran dengan sesuai code unik.</li>
            <li>Untuk mengetahui status produk silahkan cek secara berkala link track order.</li>
        </ol>
        <p>Jika masih mengalami kesulitan ketika membuat pesanan silahkan gunakan fasilitas chatting dengan cs online
            kami dengan cara klik logo chat di pojok kiri bawah.
        <p>
    </div>
</div>
@endsection