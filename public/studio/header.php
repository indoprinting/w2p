<?php
global $lumise;
include(theme('head.php'));
?>
<section id="topbar" class="d-none d-lg-block">
    <div class="container-fluid d-flex">
        <div class="contact-info">
            <a href="https://indoprinting.co.id/cara-order">Cara Order</a>
            <a href="https://indoprinting.co.id/price-list">Price List</a>
            <a href="https://indoprinting.co.id/toko-kami">Toko kami</a>
            <a href="https://indoprinting.co.id/trackorder" target="_blank">Tracking order</a>
            <a href="https://indoprinting.co.id/syarat-dan-ketentuan">Syarat & Ketentuan</a>
<!--            <a href="https://indoprinting.co.id/privacy-and-security">Privacy & Security</a>-->
            <a href="https://indoprinting.co.id/frequently-asked-questions">FAQ</a>
            <a href="https://indoprinting.co.id/antrian-online">Registrasi Pelayanan Outlet</a>
        </div>
        <div class="mx-auto">
            <a class="text-white" href="https://api.whatsapp.com/send/?phone=6282132003200&text=Indoprinting.+Ada+yang+ingin+saya+tanyakan" target="_blank">
                <i class="fab fa-whatsapp"></i> 082132003200</a>
        </div>
        <div class="auth">
            <?php if (isset($_COOKIE['nsm_session_idp']) == null) : ?>
                <a href="https://indoprinting.co.id/login">Login / Daftar</a>
            <?php else: ?>
                <?php
                $servername='localhost';
                $username='idp_w2p';
                $password="Dur14n100$";
                $dbname = "idp_w2p";
                $conn=mysqli_connect($servername,$username,$password,"$dbname");
                $users = mysqli_query($conn, "SELECT * from idp_customers where phone = '".$_COOKIE['nsm_session_idp']."' ");
                foreach ($users as $user) :
                    ?>
                    <a href="https://indoprinting.co.id/design-studio"><?= $user['name'] ?> </a> <a>|</a> <a href="https://indoprinting.co.id/logout">Logout</a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<header id="header">
    <!-- ======= Header ======= -->
    <div class="container-fluid d-flex">
        <div class="logo mt-1">
            <a href="/">
                <img src="https://indoprinting.co.id/assets/images/logo/logo-idp.png" alt="">
            </a>
        </div>
        <form action="https://indoprinting.co.id/studio/search" method="POST" enctype="multipart/form-data" class="input-group search">
            <input type="text" class="form-control search-bar" name="keyword" placeholder="Ketik tema template..." required>
            <button type="submit" class="far fa-search" name="cari" id="search-btn"></button>
        </form>
        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li><a href="/"><?php echo $lumise->lang('Beranda'); ?></a></li>
                <li><a href="https://indoprinting.co.id/produk"><?php echo $lumise->lang('Produk'); ?></a></li>
                <li><a href="https://indoprinting.co.id/studio"><?php echo $lumise->lang('Studio'); ?></a></li>
                <li><a href="<?php echo $lumise->cfg->url.'cart'; ?>"><?php echo $lumise->lang('Keranjang'); ?></a></li>
                <div class="auth-m">
                    <a href="https://indoprinting.co.id/cara-order"><?php echo $lumise->lang('Cara Order'); ?></a>
                    <a href="https://indoprinting.co.id/price-list"><?php echo $lumise->lang('Price List'); ?></a>
                    <a href="https://indoprinting.co.id/toko-kami"><?php echo $lumise->lang('Toko Kami'); ?></a>
                    <a href="https://indoprinting.co.id/trackorder" target="_blank"><?php echo $lumise->lang('Tracking Order'); ?></a>
                    <a href="https://indoprinting.co.id/privacy-and-security"><?php echo $lumise->lang('Privacy & Security'); ?></a>
                    <a href="https://indoprinting.co.id/frequently-asked-questions"><?php echo $lumise->lang('FAQ'); ?></a>
                    <a href="https://indoprinting.co.id/antrian-online"><?php echo $lumise->lang('Registrasi Pelayanan Outlet'); ?></a>
                    <?php if (isset($_COOKIE['nsm_session_idp']) == null) : ?>
                        <a href="https://indoprinting.co.id/login"><?php echo $lumise->lang('Login / Daftar'); ?></a>
                    <?php else: ?>
                        <a href="https://indoprinting.co.id/logout"><?php echo $lumise->lang('Logout'); ?></a>
                    <?php endif; ?>
                </div>
            </ul>
        </nav>
    </div>
    <?php LumiseView::navbar_categories(); ?>
</header>
