<?php
require('autoload.php');
global $lumise, $lumise_helper;

$data = $lumise->connector->get_session('lumise_cart');
$items = isset($data['items']) ? $data['items'] : array();
$fields = array(
    array('email', 'Billing E-Mail'),
    array('address', 'Street Address'),
    array('zip', 'Zip Code'),
    array('city', 'City'),
    array('country', 'Country')
);

$lumise_helper->process_cart();
$page_title = 'Keranjang Design';
setcookie("code_material", "");
setcookie("code_panjang", "");
setcookie("code_lebar", "");
setcookie("code_finishing", "");
setcookie("session_cart", "");

include(theme('header.php'));
?>
    <div class="content">
        <main>
            <section id="breadcrumbs" class="breadcrumbs">
                <div class="container-fluid">
                    <ol>
                        <li><a href="/">Beranda</a></li>
                        <li>Keranjang</li>
                    </ol>
                    <h2>Keranjang</h2>
                </div>
            </section>
            <?php
            $lumise_helper->show_sys_message();
            ?>
            <section class="container-fluid table-responsive">
                <?php if(count($items) > 0):?>
                    <div class="alert alert-warning" role="alert">
                        Anda hanya bisa menambahkan 1 pesanan di keranjang, harap untuk menyelesaikan pesanan saat ini terlebih dahulu, Terima Kasih!
                    </div>
                <?php else: ?>
                <?php endif; ?>
                <div class="cart-container">
                    <?php if(count($items) > 0):?>
                        <div class="cart">
                            <?php
                            $total = 0;
                            $index = 0;
                            foreach($items as $item):

                                $cart_data = $lumise->lib->get_cart_item_file($item['file']);
                                $meta = $lumise->lib->cart_meta($cart_data);
                                $item = array_merge($item, $cart_data);

                                ?>
                                <a id="session-cart-remove" data-cartid="<?php echo $item['cart_id'];?>" data-action="remove" href="<?php echo $lumise->cfg->url;?>cart.php?action=remove&item=<?php echo $item['cart_id'];?>" class="text-secondary fad fa-trash-alt" style="font-size:20px"></a>
                                <script type="text/javascript">
                                    document.getElementById('session-cart-remove').onclick = function() {
                                        document.cookie = "session_cart=";
                                    }
                                </script>
                                <div style="display: flex;">
                                    <div class="thumbnail">
                                        <?php
                                        if(count($item['screenshots'])> 0):
                                            foreach($item['screenshots'] as $image):?>
                                                <img src="<?php echo $lumise->cfg->upload_url.$image; ?>" />
                                            <?php endforeach;
                                        endif;
                                        ?>
                                    </div>
                                    <div class="cart-content">
                                        <div class="title"><?php echo $item['product_name'];?></div>
                                        <div class="atb">Kuantitas : <?php echo $item['qty'];?></div>
                                        <?php
                                        $bahan_dasar = explode(",",$item['bahan']);
                                        $servername='localhost';
                                        $username='idp_w2p';
                                        $password="Dur14n100$";
                                        $dbname = "idp_w2p";
                                        $conn=mysqli_connect($servername,$username,$password,"$dbname");
                                        $materials = mysqli_query($conn, "SELECT * from nsm_material where material_code = '".$bahan_dasar[1]."' ");
                                        foreach ($materials as $row) :
                                            ?>
                                            <?php $hargamaterial = $row['material_price']; ?>
                                            <div class="atb">Bahan : <?php echo $row['material_name'];?></div>
                                        <?php endforeach; ?>
                                        <div class="atb">Finishing : <?php echo $item['finishing'];?></div>
                                        <div class="atb">Ukuran : <?= $item['length'] ?> x <?= $item['width'] ?></div>

                                        <?php
                                        if(count($item['screenshots'])> 0):
                                            foreach($item['screenshots'] as $image):?>
                                                <div class="atb">Lihat Design : <a href="<?php echo $lumise->cfg->upload_url.$image; ?>" target="_blank">Klik disini</a></div>
                                            <?php endforeach;
                                        endif;
                                        ?>
                                        <?php if(false === $item['template']):?>
                                            <div class="atb">Edit Design :
                                                <a href="<?php echo $lumise->cfg->tool_url;?>?product_base=<?php echo $item['product_id'];?>&cart=<?php echo $item['cart_id'];?>&m=<?php echo $item['bahan'];?>&l=<?php echo $item['length'];?>&w=<?php echo $item['width'];?>&f=<?php echo $item['finishing'];?>" id="session-cart"><?php echo $lumise->lang('Klik disini'); ?></a>
                                            </div>
                                        <?php endif;?>
                                        <script type="text/javascript">
                                            document.getElementById('session-cart').onclick = function() {
                                                document.cookie = "session_cart=<?php echo $item['cart_id'];?>";
                                            }
                                        </script>
                                        <!-- </div> -->
                                        <div class="price mb-2">Harga <span class="float-right">
                                            <span>
                                                <?php $total += $item['price']['total'];?>
                                                <?php
                                                function rupiah($angka){
                                                    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                                                    return $hasil_rupiah;
                                                }
                                                ?>
                                                <?php if ($item['length'] == '300cm') : ?>
                                                    <?php $ukuran1 = 3 ?>
                                                <?php elseif ($item['length'] == '200cm') : ?>
                                                    <?php $ukuran1 = 2 ?>
                                                <?php elseif ($item['length'] == '150cm') : ?>
                                                    <?php $ukuran1 = 1.5 ?>
                                                <?php elseif ($item['length'] == '160cm') : ?>
                                                    <?php $ukuran1 = 1.6 ?>
                                                <?php elseif ($item['length'] == '100cm') : ?>
                                                    <?php $ukuran1 = 1 ?>
                                                <?php elseif ($item['length'] == '400cm') : ?>
                                                    <?php $ukuran1 = 4 ?>
                                                <?php elseif ($item['length'] == '500cm') : ?>
                                                    <?php $ukuran1 = 5 ?>
                                                <?php elseif ($item['length'] == '600cm') : ?>
                                                    <?php $ukuran1 = 6 ?>
                                                <?php elseif ($item['length'] == '700cm') : ?>
                                                    <?php $ukuran1 = 7 ?>
                                                <?php elseif ($item['length'] == '90cm') : ?>
                                                    <?php $ukuran1 = 1.5 ?>
                                                <?php elseif ($item['length'] == '80cm') : ?>
                                                    <?php $ukuran1 = 0.8 ?>
                                                <?php elseif ($item['length'] == '70cm') : ?>
                                                    <?php $ukuran1 = 0.7 ?>
                                                <?php elseif ($item['length'] == '60cm') : ?>
                                                    <?php $ukuran1 = 0.6 ?>
                                                <?php elseif ($item['length'] == '50cm') : ?>
                                                    <?php $ukuran1 = 0.5 ?>
                                                <?php elseif ($item['length'] == '40cm') : ?>
                                                    <?php $ukuran1 = 0.4 ?>
                                                <?php else : ?>
                                                    <?php echo 'Error' ?>
                                                <?php endif; ?>

                                                <?php if ($item['width'] == '300cm') : ?>
                                                    <?php $ukuran2 = 3 ?>
                                                <?php elseif ($item['width'] == '200cm') : ?>
                                                    <?php $ukuran2 = 2 ?>
                                                <?php elseif ($item['width'] == '150cm') : ?>
                                                    <?php $ukuran2 = 1.5 ?>
                                                <?php elseif ($item['width'] == '160cm') : ?>
                                                    <?php $ukuran2 = 1.6 ?>
                                                <?php elseif ($item['width'] == '100cm') : ?>
                                                    <?php $ukuran2 = 1 ?>
                                                <?php elseif ($item['width'] == '400cm') : ?>
                                                    <?php $ukuran1 = 4 ?>
                                                <?php elseif ($item['width'] == '500cm') : ?>
                                                    <?php $ukuran1 = 5 ?>
                                                <?php elseif ($item['width'] == '600cm') : ?>
                                                    <?php $ukuran1 = 6 ?>
                                                <?php elseif ($item['width'] == '700cm') : ?>
                                                    <?php $ukuran1 = 7 ?>
                                                <?php elseif ($item['width'] == '90cm') : ?>
                                                    <?php $ukuran1 = 1.5 ?>
                                                <?php elseif ($item['width'] == '80cm') : ?>
                                                    <?php $ukuran1 = 0.8 ?>
                                                <?php elseif ($item['width'] == '70cm') : ?>
                                                    <?php $ukuran1 = 0.7 ?>
                                                <?php elseif ($item['width'] == '60cm') : ?>
                                                    <?php $ukuran1 = 0.6 ?>
                                                <?php elseif ($item['width'] == '50cm') : ?>
                                                    <?php $ukuran1 = 0.5 ?>
                                                <?php elseif ($item['width'] == '40cm') : ?>
                                                    <?php $ukuran1 = 0.4 ?>
                                                <?php else : ?>
                                                    <?php echo 'Error' ?>
                                                <?php endif; ?>

                                                <?php $hargatotal = $ukuran1 * $ukuran2 * $hargamaterial + $total * $item['qty'] ?>
                                                <?php echo rupiah($hargatotal);?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer"></div>
                                <?php
                                $index++;
                            endforeach;
                            ?>
                        </div>

                        <div class="total-price" style="height: 190px;">
                            <div class="text">Total belanja</div>
                            <hr>
                            <div class="mobile">
                                <div class="price">
                                    <?php echo rupiah($hargatotal);?>
                                </div>
                                <div class="payment">
                                    <a href="#" id="process-checkout">
                                        <i class="fa fa-shopping-cart"></i> <?php echo $lumise->lang('Checkout'); ?>
                                    </a>
                                    <?php if (isset($_COOKIE['nsm_session_idp']) == null) : ?>
                                        <a id="checkout-button" href="https://indoprinting.co.id/login?nsm=aSu9ZHSOsRwEb4ooadEmiCKTAY5URKZQaHectau31QAY5URKZQaHectau31QoTAY5URKZQaHectau31QAY5URKZQaHetau31QAY5URKZQaHectau31QoTAY5URKZHSOsRwEb4ooadEmiCKTAY5URKZQaHectau31QAY5URKZQaHectau31QoTAY5URKZQaHectau31QAY5URKZQaHetau31QAY5URKZQaHectau31QoTAY" hidden>
                                            <?php echo $lumise->lang('Checkout Process'); ?>
                                        </a>
                                    <?php else: ?>
                                        <a id="checkout-button" href="https://indoprinting.co.id/studio/checkout" hidden>
                                            <?php echo $lumise->lang('Checkout Process'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php else:?>
                        <div style="text-align:center;margin:auto;">
                            <h3><?php echo $lumise->lang('Keranjang Anda saat ini kosong.'); ?></h3>
                            <div style="text-align: center;"><a href="<?php echo $lumise->cfg->url;?>"><?php echo $lumise->lang('Belanja Sekarang'); ?></a></div>
                        </div>
                    <?php endif;?>
                </div>
            </section>
        </main>
    </div>
    <hr/>
    <script type="text/javascript">
        document.cookie = "nsm-session-cart=aSu9ZHSOsRwEb4ooadEmiCKTAY5URKZQaHectau31QAY5URKZQaHectau31QoTAY5URKZQaHectau31QAY5URKZQaHetau31QAY5URKZQaHectau31QoTAY5URKZHSOsRwEb4ooadEmiCKTAY5URKZQaHectau31QAY5URKZQaHectau31QoTAY5URKZQaHectau31QAY5URKZQaHetau31QAY5URKZQaHectau31QoTAY=";

        (function($) {
            $('[data-action="remove"]').click(function(){
                var data = $(this).attr('data-cartid');

                var items = JSON.parse(localStorage.getItem('LUMISE-CART-DATA'));
                delete items[data];
                localStorage.setItem('LUMISE-CART-DATA', JSON.stringify(items));

            });
        })(jQuery);

        $('#process-checkout').click(function() {
            document.cookie = "nsm-link-cart=cSu9ZHSOsRwEb4ooadEmiCKTAY5URKZQaHectau31Qo=";
            document.getElementById('checkout-button').click();
        });
    </script>
<?php
include(theme('footer.php'));
$lumise->connector->set_session('lumise_cart', $data);
