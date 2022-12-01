<?php
require('autoload.php');
global $lumise;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>IDP Studio | Halaman Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="XgiZzIYOPso4ZfNIucXiNpA6OgQrQtnu5rUU0vZo">
    <!--===============================================================================================-->
    <link href="https://indoprinting.co.id/assets/images/logo/favicon.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="https://indoprinting.co.id/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://indoprinting.co.id/assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://indoprinting.co.id/assets/css/auth/util.css">
    <link rel="stylesheet" type="text/css" href="https://indoprinting.co.id/assets/css/auth/main.css">
    <link rel="stylesheet" type="text/css" href="https://indoprinting.co.id/assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="https://indoprinting.co.id/assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <script src="https://indoprinting.co.id/assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        if (localStorage.getItem('nsm-link-cart') == null){
            window.location.replace("https://indoprinting.co.id/studio/cart.php");
        }
    </script>
    <!--===============================================================================================-->
</head>

<body>
<main class="limiter">
    <div class="container-auth m-t-70">
        <img src="https://indoprinting.co.id/assets/images/promotion/1628484454_74a3e9b3e5cda167a079.png" alt="" class="logo-2">
        <div class="row">
            <div class="promotion">
                <a href="/"><img src="https://indoprinting.co.id/assets/images/promotion/1628484454_74a3e9b3e5cda167a079.png" alt="" class="mw-100"></a>
            </div>
            <div class="wrap-auth" id="auth-dengan-login">
                <div class="p-l-40 p-r-40 p-t-10 p-b-10">
                    <div class="text-center pt-3">
                        <a href="/">
                            <img src="https://indoprinting.co.id/assets/images/logo/logo-idp.png" alt="" width="250px">
                        </a>
                    </div>
                    <form class="form" method="POST" action="https://indoprinting.co.id/login" enctype="multipart/form-data" id="myForm">
                        <input type="hidden" name="_token" value="XgiZzIYOPso4ZfNIucXiNpA6OgQrQtnu5rUU0vZo">
                        <input type="hidden" name="link" value="login">
                        <div class="wrap-input">
                            <i class="far fa-user">
                            </i>
                            <span class="label-input">No. telp</span>
                            <input class="input" type="text" name="phone" value="" autocomplete="phone-off" autofocus readonly>
                            <span class="focus-input"></span>
                        </div>

                        <div class="wrap-input">
                            <i class="far fa-lock"></i><span class="label-input">Password</span>
                            <input class="input password" type="password" name="password" autocomplete="chrome-off" readonly>
                            <span class="show-password far fa-eye"></span>
                            <span class="focus-input"></span>
                        </div>

                        <div class=" forget">
                            <a href="#">Lupa password ?</a>
                        </div>
                        <a href="#">
                            <div class="button-login">
                <span>
                    Login
                </span>
                            </div>
                        </a>
                    </form>
                    <div class="dengan">atau</div>
                    <a href="#">
                        <div class="google">
                            <img src="https://indoprinting.co.id/assets/images/logo/logo-google.png" alt="">
                            <div class="text">Masuk dengan google</div>
                        </div>
                    </a>
                    <a id="checkout-withoutLogin" href="#">
                        <div class="login">Checkout tanpa login</div>
                    </a>
                    <a id="button-withoutLogin" href="<?php echo $lumise->cfg->url;?>checkout.php" hidden>
                        <div class="login">Button Checkout Without Login</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="copyright">&copy; Copyright <strong><span>indoprinting</span></strong> 2022</div>
<script src="https://indoprinting.co.id/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://indoprinting.co.id/assets/vendor/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".show-password").click(function() {
            let x = $('.password').attr('type');
            if (x == 'password') {
                $('.password').attr('type', 'text');
            } else {
                $('.password').attr('type', 'password');

            }
        });
        $('#submit').on('click', function() {
            $('#myForm').submit();
        });
    });

    $('#checkout-withoutLogin').click(function() {
        document.getElementById('button-withoutLogin').click();
        localStorage.removeItem('nsm-link-cart');
    });
</script>

</body>

</html>
