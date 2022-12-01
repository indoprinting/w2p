<div class="drawer-mobile">
    <div class="wrap">
        <div class="container-fluid">
            <div class="coloumn">
                <div class="item">
                    <a href="/">
                        <i class="fas fa-home"></i>
                        <div>Beranda</div>
                    </a>
                </div>
                <div class="item">
                    <a href="https://api.whatsapp.com/send/?phone=6282132003200&text=Indoprinting.+Ada+yang+ingin+saya+tanyakan"
                        target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        <div>Whatsapp</div>
                    </a>
                </div>
                <div class="item">
                    <a href="{{ route('profile') }}">
                        <i class="fas fa-exchange-alt"></i>
                        <div>Transaksi</div>
                    </a>
                </div>
                <div class="item">
                    <a href="{{ route('cart') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <div>Keranjang</div>
                    </a>
                </div>
                <div class="item">
                    @auth
                    <a href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <div>Logout</div>
                    </a>
                    @endauth
                    @guest
                    <a href="{{ route('loginPage') }}">
                        <i class="fas fa-sign-in-alt"></i>
                        <div>Login</div>
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>