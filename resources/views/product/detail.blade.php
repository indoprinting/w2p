@extends('layouts.main')
@section('main')
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container-fluid">
            <ol>
                <li><a href="/">Beranda</a></li>
                <li><a href="{{ route('products') }}">Produk</a></li>
                <li>{!! $product->name !!}</li>
            </ol>
        </div>
    </section>
    <section id="product-detail">
        <div class="container-fluid">
            <x-alert />
            <x-auth.validate-error :errors="$errors" />
            <div class="product">
                <div class="row">
                    <div class="col-lg-6">
                        @include('product._detail_images')
                    </div>
                    <div class="col-lg-6">
                        <h4 class="font-weight-bold mb-3">{{ $product->name }}</h4>
                        <div class="rating-share">
                            <div class="bagikan">Bagikan : </div>
                            <div style="font-size: 35px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank">
                                    <i class="fab fa-facebook-square" style="color: blue;"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank"><i class="fab fa-twitter-square" style="color:cornflowerblue;"></i></a>
                                <a href="https://plus.google.com/share?url={{ url()->current() }}" target="_blank"><i class="fab fa-google-plus-square" style="color: orangered;"></i></a>
                                <a href="whatsapp://send?text={{ url()->current() }}" data-action="share/whatsapp/share" target="_blank"><i class="fab fa-whatsapp-square" style="color: greenyellow;"></i></a>
                            </div>
                            <div class="vertical-line"></div>
                            <div class="rating-product" id="rating">
                                <div class="Stars" style="--rating: {{ $product->review_avg_rating ?? 0 }};" data-toggle="tooltip" data-placement="top" title="Rating {{ $product->review_avg_rating }} bintang">
                                </div>
                                <div class="d-flex align-items-center">
                                    ({{ $product->review_count }} Ulasan)
                                </div>
                            </div>
                        </div>
                        <div class="short-desc">
                            <div>
                                {!! $product->desc_id !!}
                            </div>
                        </div>
                        @include('product._detail_form')
                    </div>
                </div>
                @include('product._detail_description')
            </div>
        </div>
    </section>
    <script>
        let kategori_produk = "<?= $product->category ?>";
    </script>
    <script src="{{ asset('assets/js/product_detail.js') }}"></script>
@endsection
