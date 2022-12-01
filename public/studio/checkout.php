<?php
require('autoload.php');
global $lumise;

$data = $lumise->connector->get_session('lumise_cart');
$items = isset($data['items']) ? $data['items'] : array();
$fields = array(
    array('email', 'Billing E-Mail'),
    array('phone', 'Number Phone'),
    array('pickup', 'Pickup Outlet'),
);

$page_title = $lumise->lang('Checkout');
include(theme('header.php'));
?>
    <div class="content">
        <main>
            <section id="breadcrumbs" class="breadcrumbs">
                <div class="container-fluid">
                    <ol>
                        <li><a href="/">Beranda</a></li>
                        <li>Checkout</li>
                    </ol>
                    <h2>Checkout</h2>
                </div>
            </section>        <section>
                <div class="container-fluid table-responsive">
                    <?php if(count($items) > 0):?>
                        <form method="POST" action="<?php echo $lumise->cfg->url;?>process_checkout.php" id="checkoutform" accept-charset="utf-8">
                            <div class="cart-container">
                                <div>
                                    <div class="data-cust">
                                        <h5><?php echo $lumise->lang('Informasi Pelanggan'); ?></h5>
                                        <?php if (isset($_COOKIE['nsm_session_idp']) == null) : ?>
                                            <div class="cust-info">
                                                <div class="row">
                                                    <input type="text" name="pickup_method" value="Self-pickup" hidden>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Nama Depan<span style="color: red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" name="first_name" required="required" autocomplete="name-off" class="form-control " autofocus>                    </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Nama Belakang<span style="color: red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" name="last_name" required="required" class="form-control ">                    </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Email<span style="color: red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="email" name="email" required="required" class="form-control ">                    </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">No. Telp<span style="color: red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="number" name="phone" required="required" autocomplete="phone-off" class="form-control ">                    </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Alamat<span style="color: red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="text" name="address" required="required" class="form-control ">                    </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Kota<span style="color: red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="city" name="address" required="required" class="form-control ">                    </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Kode Pos<span style="color: red">*</span></label>
                                                            <div class="col-sm-12">
                                                                <input type="zip" name="address" required="required" class="form-control ">                    </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-12 col-form-label">Catatan</label>
                                                            <div class="col-sm-12">
                                                                <textarea name="catatan" rows="4" class="form-control "></textarea>                    </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="footer"></div>
                                            <div class="group-control row mt-3">
                                                <label class="col-sm-2 font-weight-bold">Alamat pickup</label>
                                                <div class="col-sm-10">
                                                    <select name="pickup" id="pickup" data-placeholder="Pilih alamat pickup" required="required" class="form-control select2 ">
                                                        <option value=""></option>
                                                        <?php
                                                        $curl = curl_init();
                                                        curl_setopt_array($curl, array(
                                                            CURLOPT_URL => 'https://printerp.indoprinting.co.id/api/v1/warehouses',
                                                            CURLOPT_RETURNTRANSFER => true,
                                                            CURLOPT_ENCODING => '',
                                                            CURLOPT_MAXREDIRS => 10,
                                                            CURLOPT_TIMEOUT => 0,
                                                            CURLOPT_FOLLOWLOCATION => true,
                                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                            CURLOPT_CUSTOMREQUEST => 'GET',
                                                        ));
                                                        $response = curl_exec($curl);
                                                        curl_close($curl);
                                                        $response_data = json_decode($response);
                                                        $user_data = $response_data->data;
                                                        $user_data = array_slice($user_data, 0, 4);
                                                        ?>
                                                        <?php foreach ($user_data as $warehouse) : ?>
                                                            <option value="<?= $warehouse->code ?>">
                                                                <?php if ($warehouse->name == 'Durian') : ?>
                                                                    Indoprinting Durian (Jl. Durian Raya No. 100, Banyumanik Semarang)
                                                                <?php elseif ($warehouse->name == 'Fatmawati') : ?>
                                                                    Indoprinting Fatmawati (Jl. Fatmawati No. 84, Pedurungan Semarang)
                                                                <?php elseif ($warehouse->name == 'Pleburan') : ?>
                                                                    Indoprinting Pleburan (Jl. Hayam Wuruk No. 30, Pleburan Semarang)
                                                                <?php elseif ($warehouse->name == 'Tembalang') : ?>
                                                                    Indoprinting Tembalang (Jl. Banjarsari No. 21, Tembalang Semarang)
                                                                <?php else : ?>
                                                                    Error
                                                                <?php endif; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>

                                                    <script>
                                                        $(document).ready(function(){
                                                            $(".select2").select2({
                                                                theme: "bootstrap4",
                                                            });
                                                        })
                                                    </script>    </div>
                                            </div>
                                            <div class="footer"></div>
                                            <div class="group-control row">
                                                <label class="col-sm-2 font-weight-bold">Metode pembayaran</label>
                                                <div class="col-sm-10">
                                                    <select name="payment" id="payment" class="select2">
                                                        <option value="Transfer">Transfer</option>
                                                        <option value="Qris">Qris (Gopay, Ovo, ShopeePay, dll)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="cust-info">
                                                <?php
                                                $servername='localhost';
                                                $username='idp_w2p';
                                                $password="Dur14n100$";
                                                $dbname = "idp_w2p";
                                                $conn=mysqli_connect($servername,$username,$password,"$dbname");
                                                $users = mysqli_query($conn, "SELECT * from idp_customers where phone = '".$_COOKIE['nsm_session_idp']."' ");
                                                foreach ($users as $user) :
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label class="col-sm-12 col-form-label">Nama Lengkap<span style="color: red">*</span></label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" value="<?= $user['name'] ?>" name="first_name" required="required" autocomplete="name-off" class="form-control " readonly>                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-12 col-form-label">Email<span style="color: red">*</span></label>
                                                                <div class="col-sm-12">
                                                                    <input type="email" value="<?= $user['email'] ?>" name="email" required="required" class="form-control ">                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-12 col-form-label">No. Telp<span style="color: red">*</span></label>
                                                                <div class="col-sm-12">
                                                                    <input type="number" value="<?= $user['phone'] ?>" name="phone" required="required" autocomplete="phone-off" class="form-control " readonly>                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label class="col-sm-12 col-form-label">Catatan</label>
                                                                <div class="col-sm-12">
                                                                    <textarea name="catatan" rows="4" class="form-control "></textarea>                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="footer"></div>
                                            <div class="group-control row mt-3">
                                                <label class="col-sm-2 font-weight-bold">Pilih Pengiriman</label>
                                                <div class="col-sm-10" id="pickup">
                                                    <select name="pickup_method" id="pickup_method" onchange="tampilkan()" class="select2">
                                                        <option value="Self-pickup">Ambil Sendiri ke Outlet</option>
                                                        <option value="Delivery">Jasa Pengiriman</option>
                                                    </select>
                                                    <p id="delivery" class="mt-2" style="visibility: hidden;">Harap masukkan alamat lengkap untuk menggunakan jasa pengiriman (Kurir). klik <a href="https://indoprinting.co.id/edit-address">disini</a> untuk update alamat.</p>
                                                </div>
                                            </div>
                                            <div class="group-control row" id="self_pickup" style="visibility: hidden;">
                                                <label class="col-sm-2 font-weight-bold">Alamat pickup</label>
                                                <div class="col-sm-10">
                                                    <select name="pickup" id="pickup" data-placeholder="Pilih alamat pickup" required="required" class="form-control select2 ">
                                                        <option value=""></option>
                                                        <?php
                                                        $curl = curl_init();
                                                        curl_setopt_array($curl, array(
                                                            CURLOPT_URL => 'https://printerp.indoprinting.co.id/api/v1/warehouses',
                                                            CURLOPT_RETURNTRANSFER => true,
                                                            CURLOPT_ENCODING => '',
                                                            CURLOPT_MAXREDIRS => 10,
                                                            CURLOPT_TIMEOUT => 0,
                                                            CURLOPT_FOLLOWLOCATION => true,
                                                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                            CURLOPT_CUSTOMREQUEST => 'GET',
                                                        ));
                                                        $response = curl_exec($curl);
                                                        curl_close($curl);
                                                        $response_data = json_decode($response);
                                                        $user_data = $response_data->data;
                                                        $user_data = array_slice($user_data, 0, 4);
                                                        ?>
                                                        <?php foreach ($user_data as $warehouse) : ?>
                                                            <option value="<?= $warehouse->code ?>">
                                                                <?php if ($warehouse->name == 'Durian') : ?>
                                                                    Indoprinting Durian (Jl. Durian Raya No. 100, Banyumanik Semarang)
                                                                <?php elseif ($warehouse->name == 'Fatmawati') : ?>
                                                                    Indoprinting Fatmawati (Jl. Fatmawati No. 84, Pedurungan Semarang)
                                                                <?php elseif ($warehouse->name == 'Pleburan') : ?>
                                                                    Indoprinting Pleburan (Jl. Hayam Wuruk No. 30, Pleburan Semarang)
                                                                <?php elseif ($warehouse->name == 'Tembalang') : ?>
                                                                    Indoprinting Tembalang (Jl. Banjarsari No. 21, Tembalang Semarang)
                                                                <?php else : ?>
                                                                    Error
                                                                <?php endif; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>

                                                    <script>
                                                        $(document).ready(function(){
                                                            $(".select2").select2({
                                                                theme: "bootstrap4",
                                                            });
                                                        })
                                                    </script>    </div>
                                            </div>
                                            <div class="footer"></div>
                                            <div class="group-control row">
                                                <label class="col-sm-2 font-weight-bold">Metode pembayaran</label>
                                                <div class="col-sm-10">
                                                    <select name="payment" id="payment" class="select2">
                                                        <option value="Transfer">Transfer</option>
                                                        <option value="Qris">Qris (Gopay, Ovo, ShopeePay, dll)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cart">
                                        <?php
                                        $total = 0;
                                        foreach($items as $item):

                                            $cart_data = $lumise->lib->get_cart_item_file($item['file']);
                                            $meta = $lumise->lib->cart_meta($cart_data);
                                            $item = array_merge($item, $cart_data);

                                            ?>
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
                                                <input type="hidden" name="code_bahan" value="<?= $row['material_code'] ?>">
                                            <?php endforeach; ?>
                                            <?php
                                            $servername='localhost';
                                            $username='idp_w2p';
                                            $password="Dur14n100$";
                                            $dbname = "idp_w2p";
                                            $conn=mysqli_connect($servername,$username,$password,"$dbname");
                                            $materials = mysqli_query($conn, "SELECT * from nsm_finishing where finishing_name = '".$item['finishing']."' ");
                                            foreach ($materials as $row) :
                                                ?>
                                                <input type="hidden" name="code_finishing" value="<?= $row['finishing_code'] ?>">
                                            <?php endforeach; ?>
                                            <a data-cartid="<?php echo $item['cart_id'];?>" data-action="remove" href="<?php echo $lumise->cfg->url;?>cart.php?action=remove&item=<?php echo $item['cart_id'];?>" class="text-secondary fad fa-trash-alt" style="font-size:20px" onclick="javascript:return confirm('Delete this item ?')"></a>
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
                                                    $servername='localhost';
                                                    $username='idp_w2p';
                                                    $password="Dur14n100$";
                                                    $dbname = "idp_w2p";
                                                    $conn=mysqli_connect($servername,$username,$password,"$dbname");
                                                    $materials = mysqli_query($conn, "SELECT * from nsm_material where material_code = '".$item['bahan']."' ");
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
                                                        <div class="atb">Edit Design : <a href="<?php echo $lumise->cfg->tool_url;?>?product_base=<?php echo $item['product_id'];?>&cart=<?php echo $item['cart_id'];?>" target="_blank"><?php echo $lumise->lang('Klik disini'); ?></a></div>
                                                    <?php endif;?>
                                                    <!-- </div> -->
                                                    <div class="price mb-2">Harga <span class="float-right">
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
                                                            <?php elseif ($item['length'] == '100cm') : ?>
                                                                <?php $ukuran1 = 1 ?>
                                                            <?php elseif ($item['length'] == '160cm') : ?>
                                                                <?php $ukuran1 = 1.6 ?>
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
                                                            <?php elseif ($item['width'] == '100cm') : ?>
                                                                <?php $ukuran2 = 1 ?>
                                                            <?php elseif ($item['width'] == '160cm') : ?>
                                                                <?php $ukuran2 = 1.6 ?>
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

                                                            <?php $hartot = $ukuran1 * $ukuran2 * $hargamaterial + $total * $item['qty'] ?>

                                                            <?php echo rupiah($hartot);?>
                                                        </span></div>
                                                </div>
                                            </div>
                                            <div class="footer"></div>
                                            <!-- modal desain -->
                                            <div class="modal fade" id="desainModal17156" tabindex="-1" role="dialog" aria-labelledby="desainModalTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered mw-100" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="desainModalTitle"><b>Desain produkku</b></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i class="far fa-times-square"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body detail-desain">
                                                            No Design
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                                <div>
                                    <div class="total-price">
                                        <div class="text2">Ongkir <span class="float-right" id="harga_ongkir">Rp 0</span></div>
                                        <div class="text2">Biaya Cetak
                                            <span class="float-right">
                                                <?php $hargatotal = $ukuran1 * $ukuran2 * $hargamaterial * $item['qty']?>
                                                <?php echo rupiah($hargatotal) ?>
                                            </span>
                                        </div>
                                        <input type="hidden" name="lebar_bahan" value="<?= $ukuran1 ?>">
                                        <input type="hidden" name="panjang_bahan" value="<?= $ukuran2 ?>">
                                        <input type="hidden" name="qty_produk" value="<?= $item['qty'] ?>">
                                        <div class="text2">Template <span class="float-right"><?php echo $lumise->lib->price($total);?></span></div>
                                    </div>
                                    <div class="total-price">
                                        <div class="text">Total Pembayaran</div>
                                        <hr>
                                        <div class="mobile">
                                            <div class="price" id="biaya"><?php $grand_total = $hargatotal + $total;?>
                                                <?php echo $lumise->lib->price($grand_total);?>
                                            </div>
                                            <div class="payment">
                                                <input type="hidden" name="action" value="placeorder">
                                                <button name="submit" type="submit" id="submit" class="btn btn-dark"><i class="fal fa-credit-card"></i> Bayar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php else:?>
                        <div class="span12">
                            <p><?php echo $lumise->lang('Your cart is currently empty.'); ?></p>
                        </div>
                        <div class="form-actions">
                            <a href="<?php echo $lumise->cfg->url;?>" class="btn btn-large btn-primary"><?php echo $lumise->lang('Continue Shopping'); ?></a>
                        </div>
                    <?php endif;?>
                </div>
            </section>
        </main>
        <script src="https://indoprinting.co.id/assets/js/checkout.js"></script>
    </div>
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
                        <a href="https://indoprinting.co.id/login">
                            <i class="fas fa-sign-in-alt"></i>
                            <div>Login</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <script type="text/javascript">
        document.cookie = "nsm-link-cart=";
        document.cookie = "nsm-session-cart=";
        jQuery(document).ready(function($) {
            $("#checkoutform").validate();
        });
        function tampilkan(){
            var pickup=document.getElementById("pickup_method").value;
            if (pickup=="Self-pickup") {
                document.getElementById("self_pickup").style.visibility = 'visible';
                document.getElementById("delivery").style.visibility = 'hidden';
            } else if (pickup=="Delivery") {
                document.getElementById("delivery").style.visibility = 'visible';
                document.getElementById("self_pickup").style.visibility = 'hidden';
            }
        }
    </script>
<?php
include(theme('footer.php'));
//update cart info
if(!isset($grand_total)){
    $grand_total = 0;
}
$data['total'] = $grand_total;
$lumise->connector->set_session('lumise_cart', $data);
