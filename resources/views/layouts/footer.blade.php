<footer class="footer">
    <div class="container-fluid">
        <div class="row none-sm">
            <div class="col-lg-4 col-sm-12">
                Support By :
                <div class="px-5 mt-2">
                    <img src="{{ asset('assets/images/logo/anteraja.png') }}" width="75" class="mx-2" alt="">
                    <img src="{{ asset('assets/images/logo/jne.png') }}" width="75" class="mx-2" alt="">
                    <img src="{{ asset('assets/images/logo/gosend.png') }}" width="50" class="mx-2" alt="">
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
{{--                <a href="https://printerp.indoprinting.co.id/" class="mx-2">Print ERP</a>--}}
            </div>
        </div>
        <br />
        <hr />
        <div class="copyright">
            &copy; Copyright <strong><span>indoprinting</span></strong>
            {{ date('Y') != 2021 ? '2021 - ' : '' }}
            {{ date('Y') }}
        </div>
    </div>
</footer>
