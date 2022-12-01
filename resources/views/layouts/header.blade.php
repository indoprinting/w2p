<!-- ======= Top Bar ======= -->
<section id="topbar" class="d-none d-lg-block">
    <div class="container-fluid d-flex">
        <div class="contact-info">
            <a href="{{ route('cara.order') }}">Cara Order</a>
            <a href="{{ route('price.list') }}">Price List</a>
            <a href="{{ route('toko.kami') }}">Toko kami</a>
            <a href="{{ route('track.order.w2p') }}" target="_blank">Tracking order</a>
            <a href="{{ route('term') }}">Syarat & Ketentuan</a>
{{--            <a href="{{ route('privacy') }}">Privacy & Security</a>--}}
            <a href="{{ route('faq') }}">FAQ</a>
            <a href="{{ route('queue.online') }}">Registrasi Pelayanan Outlet</a>
        </div>
        <div class="mx-auto">
            <a class="text-white" href="https://api.whatsapp.com/send/?phone=6282132003200&text=Indoprinting.+Ada+yang+ingin+saya+tanyakan" target="_blank">
                <i class="fab fa-whatsapp"></i> 082132003200</a>
        </div>
        <div class="auth">
            @auth
                <a href="{{ route('profile') }}">
                    {{ Auth()->user()->name ?? 'Profilku' }}
                </a>
                <a>|</a>
                <a href="{{ route('logout') }}">Logout</a>
            @endauth
            @guest
                <a href="{{ route('loginPage') }}">Login / Daftar</a>
            @endguest
        </div>
    </div>
</section>
<header id="header">
    <!-- ======= Header ======= -->
    <div class="container-fluid d-flex">
        <div class="logo mt-1">
            <a href="/">
                <x-logo />
            </a>
        </div>
        <form action="{{ route('pencarian') }}" method="GET" enctype="multipart/form-data" class="input-group search">
            <input type="text" class="form-control search-bar" name="keyword" id="search-bar" value="{{ $keyword ?? null }}" placeholder="Ketik nama produk...">
            <button type="submit" class="far fa-search" id="search-btn"></button>
        </form>
        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="{{ route('products') }}">Produk</a></li>
                <li><a href="#">Studio</a></li>
                <li><a href="{{ route('cart') }}">Keranjang</a></li>
                <div class="auth-m">
                    <a href="{{ route('cara.order') }}">Cara Order</a>
                    <a href="{{ route('price.list') }}">Price List</a>
                    <a href="{{ route('toko.kami') }}">Toko kami</a>
                    <a href="{{ route('track.order.w2p') }}" target="_blank">Tracking order</a>
                    <a href="{{ route('privacy') }}">Privacy & Security</a>
                    <a href="{{ route('faq') }}">FAQ</a>
                    <a href="{{ route('queue.online') }}">Registrasi Pelayanan Outlet</a>

                    @auth
                        <a href="{{ route('profile') }}">
                            {{ Auth()->user()->name ?? 'Profilku' }}
                        </a>
                        <a href="{{ route('logout') }}">Logout</a>
                    @endauth
                    @guest
                        <a href="{{ route('loginPage') }}">Login / Daftar</a>
                    @endguest
                </div>
            </ul>
        </nav>
    </div>
    <div class="container-fluid category-nav">
        <div class="row">
            @foreach ($product_categories as $category)
                <a class="border-nav {{ Request::is('kategori-produk/' . $category->id_category) ? ' border-hover' : '' }}" href="{{ route('category', $category->id_category) }}">
                    <div>
                        {!! $category->name !!}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</header>
