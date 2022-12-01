@extends('layouts.main')
@section('main')
    <main>
        <x-breadcrumb title="Keranjang" />
        <section class="container-fluid table-responsive">
            <x-alert />
            <div class="cart-container">
                @if (count($carts) > 0)
                    @include('cart._cart')

                    <div class="total-price" style="height: 190px;">
                        <div class="text">Total belanja</div>
                        <hr>
                        <div class="mobile">
                            <div class="price">{{ rupiah($total) }}</div>
                            <div class="payment">
                                <a href="{{ $total > 9999 ? route('checkout') : '#' }}" id="{{ $total < 10000 ? 'notif' : '' }}"><i class="fas fa-shopping-cart"></i> Checkout</a>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- <div style="margin-left: 20px;color:red;font-size:12px;">Silahkan lanjut Checkout, karena item di keranjang akan terhapus otomatis setelah 1 minggu.</div> -->
        </section>
        <section class="product-terkait mt-5">
            <div class="container-fluid">
                <h5 class="ml-2">Produk Terkait</h5>
                <div class="row">
                    <div class="owl-carousel">
                        @foreach ($relates as $relate)
                            <div class="icon-box" style="padding-bottom:20px;">
                                <div class="box">
                                    <div class="frame">
                                        <a href="{{ route('product', $relate->id_product) }}">
                                            <div class="icon"><img src="{{ adminUrl('assets/images/products-img/' . $relate->thumbnail) }}"></div>
                                            <div class="text">{{ $relate->name }}</div>
                                            <div class="price">Start <b>{{ rupiah($relate->min_price) }}</b>
                                            </div>
                                            <div class="rating-sold">
                                                <i class="fas fa-star"></i> {{ $relate->review_avg_rating ?? 0 }} | Terjual {{ soldThousand($relate->best_seller_sum_qty) ?? 0 }}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @else
        <div style="text-align:center;margin:auto;">
            <h3>Keranjang kosong</h3>
            <div style="text-align: center;"><a href="{{ route('products') }}">Belanja sekarang</a></div>
        </div>
        @endif
        <script>
            $(document).ready(function() {
                $('#notif').on('click', function() {
                    alert('Mohon maaf, untuk melanjutkan checkout minimal belanja Rp 10.000');
                });
                let owl = $('.owl-carousel');
                if (window.matchMedia("(max-width: 767px)").matches) {
                    owl.owlCarousel({
                        items: 2,
                        loop: true,
                        margin: 10,
                        autoplay: false,
                        autoplayTimeout: 1500,
                        autoplayHoverPause: true,
                        dots: true,
                    });
                } else {
                    owl.owlCarousel({
                        items: 5,
                        loop: true,
                        margin: 10,
                        autoplay: true,
                        autoplayTimeout: 1500,
                        autoplayHoverPause: true,
                        dots: false,
                    });
                }
            });
        </script>
    </main>

@endsection
