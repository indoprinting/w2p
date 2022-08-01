@extends('layouts.main')
@section('main')
    <div class="container-fluid">
        <div id="carousel-idp" class="carousel slide" data-ride="carousel">
            <x-banner :banners="$banner" />
        </div>
        <a href="{{ route('cara.order') }}">
            <img src="{{ adminUrl('assets/images/admin/cara-order.jpg') }}" alt="" style="max-width: 100%;" class="img-order">
        </a>
    </div>

    <main id="main">
        <section class="product-list">
            <div class="container-fluid">
                <div class="category-list">
                    Produk Terlaris
                </div>
                <x-product-view :products="$best_seller" />
                <div class="category-list">
                    Produk Terbaru
                </div>
                <x-product-view :products="$newest" />
                @foreach ($categories as $category)
                    @if ($category->products)
                        <div class="category-list">
                            {!! $category->name !!} <a href="{{ route('category', $category->id_category) }}">Lihat semua</a>
                        </div>
                        <x-product-view :products="$category->products" />
                    @endif
                @endforeach
                <hr>
                @if ($our_work->isNotEmpty())
                    <h3 class="title-ow">Our Work</h3>
                    <div class="row">
                        <div class="owl-carousel">
                            @foreach ($our_work as $image)
                                <div class="img-ow">
                                    <img src="{{ adminUrl('assets/images/our-work/' . $image->img) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="term-ow">
                            <b>Disclamer: </b>All product and company names are trademarks™ or registered® trademarks of their respective holders. Use of them does not imply any affiliation with or endorsement by them.
                        </div>
                    </div>
                    <hr>
                @endif
            </div>
        </section>
    </main>
    <script>
        $(document).ready(function() {
            $('.w-100').hover(function() {
                $('.carousel-control-prev-icon').addClass('hover');
            });

            //our-work
            let owl = $('.owl-carousel');
            owl.owlCarousel({
                items: 6,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 1500,
                autoplayHoverPause: true,
                dots: false,
            });
        });
    </script>
    @include('layouts.footer_mobile')
@endsection
