<?php

require('autoload.php');
global $lumise, $lumise_helper;

$order = $lumise->connector->get_session('lumise_justcheckout');
$order_id = $order['id'];
$user = $order['user'];

if(isset($_POST['txn_id'])){
    //update order data
    $db = $lumise->get_db();
	$db->where ('id', $order_id)->update ('orders', array(
        'txn_id' => $_POST['txn_id'],
    ));

	$db->where ('id', $order_id);
	$db->where ('status', 'pending')->update ('orders', array(
        'status' => 'processing'
    ));
    $order['status'] = 'processing';
}

$page_title = $lumise->lang('Thank you');

include(theme('header.php'));

?>
    <table class="lumise-table" hidden>
        <tbody>
        <?php
        $items = $order['items'];
        $total = 0;
        foreach($items as $item):
            $cart_data = $lumise->lib->get_cart_item_file($item['file']);
            $item = array_merge($item, $cart_data);
            ?>
            <tr>
                <td>
                    <span class="product-title"><?php echo $item['product_name'];?></span>
                    x <?php echo $item['qty'];?>
                </td>
                <td>
                    <?php echo $lumise->lib->price($item['price']['total']); ?>
                    <?php $total += $item['price']['total']; ?>
                </td>
            </tr>
        <?php endforeach;?>
        <tr>
            <td><strong><?php echo $lumise->lang('Grand Total'); ?></strong></td>
            <td><?php $grand_total = $total?><?php echo $lumise->lib->price($grand_total);?></td>
        </tr>
        </tfoot>
    </table>


    <div class="content">
        <div class="container table-responsive">
            <div class="payment-wrapper">
                <div class="payment-total">
                    <p class="invoice">
                        <strong>INV-2022/11/12581</strong>
                        <span class="float-right">
                        Need Payment
                    </span>
                        <br><?php echo $user['name'];?>
                    </p>
                    <h5>Total pembayaran</h5>
                    <h4 id="total" style="font-weight: 700;color:red;">
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
                            <?php $grand_total = $total +  $row['material_price']?><?php echo $lumise->lib->price($grand_total);?>
                        <?php endforeach; ?>
                        <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#total')"></a>
                    </h4>

                    <div class="detail"><a href="javascript:void(0);" id="detail" data-toggle="modal" data-target="#paymentModal">Lihat detail</a></div>
                    <div class="payment-note">
                        Mohon transfer sesuai nominal agar dapat tervalidasi otomatis <br>
                        Proses validasi membutuhkan waktu sekitar 5 menit
                    </div>
                </div>
                <div class="payment-head">
                    <h4>Batas akhir pembayaran</h4>
                    <h5>Rabu, 23 November 2022 15:15</h5>
                </div>
                <div class="payment-bank">
                    <table class="table table-bordered">
                        <tr>
                            <th style="text-align:center;">No. Rekening</th>
                            <th>Nama Bank</th>
                            <th>Atas Nama</th>
                        </tr>
                        <tr>
                            <td>
                                <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#bri')"></a><span id="bri">0083 01 001092 56 5</span>
                            </td>
                            <td class="td-img"><img src="https://indoprinting.co.id/assets/images/logo/logo_bri.png" alt="" class="img-bank"></td>
                            <td>CV. Indoprinting</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#bni')"></a><span id="bni">5592 09008</span>
                            </td>
                            <td class="td-img"><img src="https://indoprinting.co.id/assets/images/logo/logo_bni.png" alt="" class="img-bank"></td>
                            <td>CV. Indoprinting</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#mandiri')"></a><span id="mandiri">1360 0005 5532 3</span>
                            </td>
                            <td class="td-img"><img src="https://indoprinting.co.id/assets/images/logo/logo_mandiri.png" alt="" class="img-bank"></td>
                            <td>CV. Indoprinting</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="javascript:void(0);" class="fad fa-copy" onclick="copyToClipboard('#bca')"></a><span id="bca">8030 200234</span>
                            </td>
                            <td class="td-img"><img src="https://indoprinting.co.id/assets/images/logo/logo_bca.png" alt="" class="img-bank"></td>
                            <td>Anita Ratnasari</td>
                        </tr>
                    </table>
                </div>

                <script>
                    function copyToClipboard(element) {
                        let text = $(element).text().replace(/\D/g, "");
                        var $temp = $("<input>");
                        $("body").append($temp);
                        $temp.val(text).select();
                        document.execCommand("copy");
                        alert('Teks disalin');
                        $temp.remove();
                    }
                </script>
                <div class="payment-button">
                    <a href="https://indoprinting.co.id/trackorder?invoice=INV-2022%2F11%2F12581" target="_blank" class="tracking">Tracking order</a>
                    <div style="margin:0 50px 0 50px;">
                    </div>
                    <a href="javascript:void(0);" class="tombol bukti-tf" data-toggle="modal" data-target="#uploadFile">Unggah
                        bukti pembayaran (optional)
                        <span data-toggle="tooltip" data-placement="top" title="Unggah bukti pembayaran untuk mempercepat proses validasi pembayaran" class="fad fa-question-circle"></span>
                    </a>
                    <form action="https://indoprinting.co.id/payment/ganti-metode-pembayaran" method="POST" id="myForm" class="mb-3 mt-5">
                        <input type="hidden" name="_token" value="AAdeVJEgRk8Q2upwbPtJQptAGGJ3ra4oLxw4cPIh">                        <input type="hidden" name="id" value="520">
                        <input type="hidden" name="phone" value="08999262320">
                        <input type="hidden" name="invoice" value="INV-2022/11/12581">
                        <input type="hidden" name="current" value="Transfer">
                        <a href="javascript:void(0);" class="metode" id="submit">Ganti metode pembayaran ke <strong>Cashier / Kasir</strong> ?</a>
                    </form>
                    <div class=" mt-5 ">
                        <a href="/" class="tombol belanja">Belanja Lagi</a>
                        <input type="text" value="https://indoprinting.co.id/studio/success.php?order_id=<?php echo $order_id;?>" id="myInput" hidden>
                        <a href="#" class="tombol cek" onclick="myFunction();"> Save Invoice</a>
                        <script type="text/javascript">
                            function myFunction() {
                                // Get the text field
                                var copyText = document.getElementById("myInput");

                                copyText.select();
                                copyText.setSelectionRange(0, 99999);

                                navigator.clipboard.writeText(copyText.value);
                                alert('Invoice berhasil di simpan')
                            }
                        </script>
                    </div>
                </div>
            </div>
            <!-- Modal detail-->
            <div class="modal fade" id="paymentModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="paymentModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalTitle"><strong>Detail pembayaran</strong></h5>
                            <button type="button" class="close" id="close-detail" data-dismiss="modal" aria-label="Close">
                                <i class="far fa-times-square"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-detail">
                                <div>Status Pembayaran<span class="float-right" id="payment-status">Waiting Transfer</span></div>
                                <div>No. Invoice<span class="float-right">INV-2022/11/12581</span></div>
                                <div>Tanggal<span class="float-right"><?php echo $order['created'];?></span></div>
                                <div>Nama Pelanggan<span class="float-right"><?php echo $user['name'];?></span></div>
                                <div>No. Telp<span class="float-right"><?php echo $user['phone'];?></span></div>
                                <div>Alamat<span class="float-right"><?php echo $user['address'];?>, <?php echo $user['city'];?>, <?php echo $user['zipcode'];?></span></div>
                                <hr>
                                <?php
                                $items = $order['items'];
                                $total = 0;
                                foreach($items as $item):
                                    $cart_data = $lumise->lib->get_cart_item_file($item['file']);
                                    $item = array_merge($item, $cart_data);
                                    ?>
                                    <div><?php echo $item['product_name'];?></div>
                                    <div class="qty">Kuantitas : <?php echo $item['qty'];?><span class="float-right">
                                        <?php echo $lumise->lib->price($item['price']['total']); ?>
                                        <?php $total += $item['price']['total']; ?>
                                    </span></div>
                                    <p class="atb"><strong>Ukuran</strong> : Sesuiakan dengan design</p>
                                    <p class="atb"><strong>Material</strong> : Sesuaikan dengan pilihan saya</p>
                                <?php endforeach;?>
                                <hr>
                                <div>Sub total<span class="float-right"><?php echo $lumise->lib->price($grand_total);?></span></div>
                                <div>Kode unik<span class="float-right">2</span></div>
                                <hr>
                                <div><strong>Total pembayaran</strong>
                                    <span class="float-right">
                            <strong style="color:orangered;"><?php $grand_total = $total?><?php echo $lumise->lib->price($grand_total);?></strong>
                        </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal upload-->
            <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadFileTitle"><strong>Unggah bukti pembayaran</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="far fa-times-square"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <ol>
                                    <li>File harus berupa gambar dengan ekstensi jpg / png / jpeg.</li>
                                    <li>Unggah bukti pembayaran untuk mempercepat proses validasi pembayaran.</li>
                                    <li><strong style="color: red;">Penting. Harap unggah bukti transfer sesuai nominal total pembayaran.</strong></li>
                                </ol>
                            </div>
                            <hr>
                            <form action="https://indoprinting.co.id/payment/upload-bukti-pembayaran" method="POST" enctype="multipart/form-data" id="upload-tf">
                                <input type="hidden" name="_token" value="AAdeVJEgRk8Q2upwbPtJQptAGGJ3ra4oLxw4cPIh">                        <input type="hidden" name="id" value="520">
                                <input type="hidden" name="phone" value="08999262320">
                                <input type="file" name="bukti_tf" id="unggah">
                                <button type="submit" class="btn btn-info" style="display: none;" id="submit-upload">Unggah</button>
                            </form>
                            <div style="text-align: center;">
                                <img src="https://indoprinting.co.id/assets/images/bukti-transfer" alt="" id="upload-preview" class="img-upload">
                                <div style="font-size: 10px;display:none;" class="text-upload"><a href="#" class="btn btn-info" id="upload2">upload sekarang</a>.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#upload2').on('click', function() {
                        $('#upload-tf').submit();
                    });

                    $('#upload-tf').on('change', function() {
                        $(".text-upload").show();
                    });
                });
            </script>
        </div>
        <script>
            $(document).ready(function() {
                $("#submit").click(function() {
                    let r = confirm("Ganti metode pembayaran ?");
                    if (r == true) {
                        $('#myForm').submit();
                    } else {
                        console.log('CANCEL');
                    }
                });

                let user = "";
                if (!user) {
                    alert("Harap simpan no invoice karena pelanggan melakukan order tanpa login");
                }
            });
        </script>
    </div>
    <hr />
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

<?php

if(isset($_GET['order_id']) && isset($order['id']) && $order['id'] == $_GET['order_id']){
    echo "<script>localStorage.setItem('LUMISE-CART-DATA', '');</script> ";
}

include(theme('footer.php'));

