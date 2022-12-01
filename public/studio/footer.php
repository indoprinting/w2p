<?php global $lumise;
?>
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
                    <a href="https://indoprinting.co.id/daftar-belanja">
                        <i class="fas fa-exchange-alt"></i>
                        <div>Transaksi</div>
                    </a>
                </div>
                <div class="item">
                    <a href="https://indoprinting.co.id/keranjang">
                        <i class="fas fa-shopping-cart"></i>
                        <div>Keranjang</div>
                    </a>
                </div>
                <div class="item">
                    <?php if (isset($_COOKIE['nsm_session_idp']) == null) : ?>
                        <a href="https://indoprinting.co.id/login">
                            <i class="fas fa-sign-in-alt"></i>
                            <div>Login</div>
                        </a>
                    <?php else: ?>
                        <a href="https://indoprinting.co.id/logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <div>Logout</div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>    <footer class="footer">
    <div class="container-fluid">
        <div class="row none-sm">
            <div class="col-lg-4 col-sm-12">
                Support By :
                <div class="px-5 mt-2">
                    <img src="https://indoprinting.co.id/assets/images/logo/anteraja.png" width="75" class="mx-2" alt="">
                    <img src="https://indoprinting.co.id/assets/images/logo/jne.png" width="75" class="mx-2" alt="">
                    <img src="https://indoprinting.co.id/assets/images/logo/gosend.png" width="50" class="mx-2" alt="">
                </div>
            </div>
            <div class="col-lg-5 col-sm-12">
                Kontak Kami :
                <div class="sosmed">
                    <a class="text-success fab fa-whatsapp" href="https://api.whatsapp.com/send/?phone=6282132003200&text=Indoprinting.+Ada+yang+ingin+saya+tanyakan" target="_blank"></a>
                    <a class="far fa-envelope" href="mailto:online@indoprinting.co.id" target="_blank" style="color:rgb(85, 201, 85);"></a>
                    <a class="fas fa-shopping-bag" href="https://www.tokopedia.com/idpoa" target="_blank" style="color:green;"></a>
                    <a class="fab fa-facebook-square" href="https://www.facebook.com/mkt.indoprinting" target="_blank" style="color: blue;"></a>
                    <a class="fab fa-twitter-square" href="https://twitter.com/indoprinting" target="_blank" style="color:skyblue"></a>
                    <a class="fab fa-instagram-square" href="https://www.instagram.com/indoprinting/" target="_blank" style="color:purple"></a>
                    <a class="fab fa-youtube" href="https://www.youtube.com/channel/UCJc2peAwQ_OHfTWw9MPwYrg" target="_blank" style="color:rgb(240, 64, 64)"></a>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div>Feature :</div>
                <a href="#" class="mx-2">Design Studio (Coming Soon)</a>
<!--                <a href="https://printerp.indoprinting.co.id/" class="mx-2">Print ERP</a>-->
            </div>
        </div>
        <br />
        <hr />
        <div class="copyright">
            &copy; Copyright <strong><span>indoprinting</span></strong>
            2021 -
            2022
        </div>
    </div>
</footer>
<!-- Vendor JS Files -->
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="https://indoprinting.co.id/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="https://indoprinting.co.id/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://indoprinting.co.id/assets/vendor/select2/js/select2.full.min.js"></script>
<script src="https://indoprinting.co.id/assets/vendor/summernote/summernote.min.js"></script>

<!-- Main JS File -->
<script src="https://indoprinting.co.id/assets/js/myJs.js"></script>
<script src="https://indoprinting.co.id/assets/js/template.js"></script>
<script type="text/javascript">
    var cpath = window.location.pathname;
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/6090ed3e185beb22b309c2c5/1f4r1tfnt';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
    Tawk_API.onLoad = function() {

        setTimeout(function() {
            $('iframe[src="about:blank"]')[0].style.bottom = '93px';
        }, 1000);

        setTimeout(function() {
            $('iframe[src="about:blank"]')[0].style.bottom = '93px';
        }, 1000);
    };
</script>
</body>

</html>
<?php $lumise->do_action('footer_lumise_php'); ?>
</body>
</html>