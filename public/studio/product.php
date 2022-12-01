<?php

require('autoload.php');
global $lumise, $lumise_helper;

$id = isset($_GET['product_id']) ? $_GET['product_id'] : '1';
$value = $lumise->lib->get_row_id($id, 'products');

$orderby  = 'name';
$ordering = 'desc';
$dt_order = 'name_asc';
$current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;

$search_filter = array(
    'keyword' => '',
    'fields' => 'name'
);

$default_filter = array(
    'type' => '',
);
$per_page = 4;
$start = ( $current_page - 1 ) * $per_page;
$data = $lumise->lib->get_rows('products', $search_filter, $orderby, $ordering, $per_page, $start, array('active'=> 1), '');
$thumbnail_url = 'https://indoprinting.co.id/studio/assets/images/favicon.png';
if(!empty($value['thumbnail_url']))
    $thumbnail_url = $value['thumbnail_url'];

$page_title = isset($value['name']) ? $value['name'] : 'Product Details';

$has_template = $lumise_helper->has_template($value);

setcookie("code_material", "");
setcookie("code_panjang", "");
setcookie("code_lebar", "");
setcookie("code_finishing", "");
setcookie("session_cart", "");

include(theme('header.php'));
?>
<div class="content">
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container-fluid">
            <ol>
                <li><a href="/">Beranda</a></li>
                <li><a href="https://indoprinting.co.id/studio/">IDP Design Studio</a></li>
                <li><?php if(isset($value['name'])) echo $value['name']; ?></li>
            </ol>
        </div>
    </section>
    <section id="product-detail">
        <div class="container-fluid">
            <div class="product">
                <div class="row">
                    <div class="col-lg-6">
                        <p>Preview Template</p>
                        <img id="img" src="<?php echo $thumbnail_url;?>" style="max-width:100%;">
                        <div class="modal-img-zoom">
                            <span class="close-modal-zoom">&times;</span>
                            <img class="content">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="font-weight-bold mb-3"><?php if(isset($value['name'])) echo $value['name']; ?></h4>
                        <div class="rating-share">
                            <div class="bagikan">Bagikan : </div>
                            <div style="font-size: 35px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= (isset($_SERVER["HTTPS"]) ? "https://" : "http://") ?><?= $_SERVER["HTTP_HOST"] ?><?= $_SERVER["REQUEST_URI"] ?>" target="_blank">
                                    <i class="fab fa-facebook-square" style="color: blue;"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= (isset($_SERVER["HTTPS"]) ? "https://" : "http://") ?><?= $_SERVER["HTTP_HOST"] ?><?= $_SERVER["REQUEST_URI"] ?>" target="_blank"><i class="fab fa-twitter-square" style="color:cornflowerblue;"></i></a>
                                <a href="https://plus.google.com/share?url=<?= (isset($_SERVER["HTTPS"]) ? "https://" : "http://") ?><?= $_SERVER["HTTP_HOST"] ?><?= $_SERVER["REQUEST_URI"] ?>" target="_blank"><i class="fab fa-google-plus-square" style="color: orangered;"></i></a>
                                <a href="whatsapp://send?text=<?= (isset($_SERVER["HTTPS"]) ? "https://" : "http://") ?><?= $_SERVER["HTTP_HOST"] ?><?= $_SERVER["REQUEST_URI"] ?>" data-action="share/whatsapp/share" target="_blank"><i class="fab fa-whatsapp-square" style="color: greenyellow;"></i></a>
                            </div>
                            <div class="vertical-line"></div>
                            <div class="rating-product" id="rating">
                                <div class="Stars" style="--rating: 5;" data-toggle="tooltip" data-placement="top" title="Rating 5 bintang">
                                </div>
                                <div class="d-flex align-items-center">
                                    (6 Ulasan)
                                </div>
                            </div>
                        </div>
                        <div class="short-desc">
                            <div>
                                <?php if(isset($value['description']) && !empty($value['description'])) echo $value['description']; ?>
                            </div>
                        </div>
                        <form method="get" action="<?= $lumise->cfg->tool_url ?>">
                            <input name="product_base" value="<?= $value['id'] ?>" hidden/>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Isian & Pilihan</th>
                                    <th width="20%">Harga</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Jenis Bahan</td>
                                    <td class="nol">
                                        <select name="m" id="bahan" class="form-control " onchange="myFunction(event)">
                                            <?php
                                            $servername='localhost';
                                            $username='idp_w2p';
                                            $password="Dur14n100$";
                                            $dbname = "idp_w2p";
                                            $conn=mysqli_connect($servername,$username,$password,"$dbname");
                                            $materials = mysqli_query($conn, "SELECT * from nsm_material");
                                            foreach ($materials as $row) :
                                                ?>
                                                <option value="<?= $row['material_name'] ?>,<?= $row['material_code'] ?>,<?= $row['material_price'] ?>" >
                                                    <?= $row['material_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td id="hargabahan">Rp 19.000</td>
                                </tr>
                                <tr>
                                    <td>Panjang</td>
                                    <td class="nol">
                                        <?php
                                        $servername='localhost';
                                        $username='idp_w2p';
                                        $password="Dur14n100$";
                                        $dbname = "idp_w2p";
                                        $conn=mysqli_connect($servername,$username,$password,"$dbname");
                                        $panjangkali = mysqli_query($conn, "SELECT * from nsm_products WHERE id = '".$_GET['product_id']."'");
                                        ?>
                                        <?php foreach ($panjangkali as $panjang) : ?>
                                            <?php $pecah = explode(" ",$panjang['name']); ?>
                                        <?php endforeach; ?>
                                        <select class="form-control " name="l">
                                            <?php if ($pecah[0] == '300cm') : ?>
                                                <option value="300cm">300cm</option>
                                            <?php elseif ($pecah[0] == '200cm') : ?>
                                                <option value="200cm">200cm</option>
                                            <?php elseif ($pecah[0] == '150cm') : ?>
                                                <option value="150cm">150cm</option>
                                            <?php elseif ($pecah[0] == '160cm') : ?>
                                                <option value="160cm">160cm</option>
                                            <?php elseif ($pecah[0] == '100cm') : ?>
                                                <option value="100cm">100cm</option>
                                            <?php elseif ($pecah[0] == '400cm') : ?>
                                                <option value="400cm">400cm</option>
                                            <?php elseif ($pecah[0] == '500cm') : ?>
                                                <option value="500cm">500cm</option>
                                            <?php elseif ($pecah[0] == '600cm') : ?>
                                                <option value="600cm">600cm</option>
                                            <?php elseif ($pecah[0] == '700cm') : ?>
                                                <option value="700cm">700cm</option>
                                            <?php elseif ($pecah[0] == '90cm') : ?>
                                                <option value="90cm">90cm</option>
                                            <?php elseif ($pecah[0] == '80cm') : ?>
                                                <option value="80cm">80cm</option>
                                            <?php elseif ($pecah[0] == '70cm') : ?>
                                                <option value="70cm">70cm</option>
                                            <?php elseif ($pecah[0] == '60cm') : ?>
                                                <option value="60cm">60cm</option>
                                            <?php elseif ($pecah[0] == '50cm') : ?>
                                                <option value="50cm">50cm</option>
                                            <?php elseif ($pecah[0] == '40cm') : ?>
                                                <option value="40cm">40cm</option>
                                            <?php else : ?>
                                                <option value="Error">Error</option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Lebar</td>
                                    <td class="nol">
                                        <select class="form-control " name="w">
                                            <?php if ($pecah[2] == '300cm') : ?>
                                                <option value="300cm">300cm</option>
                                            <?php elseif ($pecah[2] == '200cm') : ?>
                                                <option value="200cm">200cm</option>
                                            <?php elseif ($pecah[2] == '150cm') : ?>
                                                <option value="150cm">150cm</option>
                                            <?php elseif ($pecah[2] == '160cm') : ?>
                                                <option value="160cm">160cm</option>
                                            <?php elseif ($pecah[2] == '100cm') : ?>
                                                <option value="100cm">100cm</option>
                                            <?php elseif ($pecah[2] == '400cm') : ?>
                                                <option value="400cm">400cm</option>
                                            <?php elseif ($pecah[2] == '500cm') : ?>
                                                <option value="500cm">500cm</option>
                                            <?php elseif ($pecah[2] == '600cm') : ?>
                                                <option value="600cm">600cm</option>
                                            <?php elseif ($pecah[2] == '700cm') : ?>
                                                <option value="700cm">700cm</option>
                                            <?php elseif ($pecah[2] == '90cm') : ?>
                                                <option value="90cm">90cm</option>
                                            <?php elseif ($pecah[2] == '80cm') : ?>
                                                <option value="80cm">80cm</option>
                                            <?php elseif ($pecah[2] == '70cm') : ?>
                                                <option value="70cm">70cm</option>
                                            <?php elseif ($pecah[2] == '60cm') : ?>
                                                <option value="60cm">60cm</option>
                                            <?php elseif ($pecah[2] == '50cm') : ?>
                                                <option value="50cm">50cm</option>
                                            <?php elseif ($pecah[2] == '40cm') : ?>
                                                <option value="40cm">40cm</option>
                                            <?php else : ?>
                                                <option value="Error">Error</option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Finishing</td>
                                    <td class="nol">
                                        <select name="f" class="form-control ">
                                            <?php
                                            $servername='localhost';
                                            $username='idp_w2p';
                                            $password="Dur14n100$";
                                            $dbname = "idp_w2p";
                                            $conn=mysqli_connect($servername,$username,$password,"$dbname");
                                            $finishing = mysqli_query($conn, "SELECT * from nsm_finishing");
                                            ?>
                                            <?php foreach ($finishing as $finish) : ?>
                                            <option value="<?= $finish['finishing_name'] ?>" >
                                                <?= $finish['finishing_name'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if ($value['price'] == 0) : ?>
                                            Gratis
                                        <?php else: ?>
                                            <?= $lumise->lib->price($value['price']) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Template</td>
                                    <td class="nol">
<!--                                        <select name="quantity" id="quantity" class="form-control " onchange="myFunction2(event)" disabled>-->
<!--                                            <option value="1" >-->
<!--                                                1-->
<!--                                            </option>-->
<!--                                            <option value="2" >-->
<!--                                                2-->
<!--                                            </option>-->
<!--                                            <option value="3" >-->
<!--                                                3-->
<!--                                            </option>-->
<!--                                            <option value="4" >-->
<!--                                                4-->
<!--                                            </option>-->
<!--                                            <option value="5" >-->
<!--                                                5-->
<!--                                            </option>-->
<!--                                            <option value="6" >-->
<!--                                                6-->
<!--                                            </option>-->
<!--                                            <option value="7" >-->
<!--                                                7-->
<!--                                            </option>-->
<!--                                        </select>-->
                                    </td>
                                    <td id="totaljumlah">
                                        <?php if ($value['price'] == 0) : ?>
                                            Gratis
                                        <?php else: ?>
                                            <?= $lumise->lib->price($value['price']) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Harga</td>
                                    <td class="nol"></td>
                                    <td id="hargatotal">Rp 19.000</td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- note -->
                            <div>
                                <button type="submit" id="goto-studio" class="btn btn-secondary btn-block"><i class="fas fa-pencil"></i> Edit design saya</button>
                            </div>
                            <script type="text/javascript">
                                function myFunction(e) {
                                    var fungsiambilbahan = e.target.value
                                    var ambilharga = fungsiambilbahan.split(",");

                                    const numb = ambilharga[2];
                                    const format = numb.toString().split('').reverse().join('');
                                    const convert = format.match(/\d{1,3}/g);
                                    const rupiah = 'Rp ' + convert.join('.').split('').reverse().join('')

                                    document.getElementById("hargabahan").innerHTML = rupiah
                                    document.getElementById("hargatotal").innerHTML = rupiah
                                }
                                //function myFunction2(e) {
                                //    const numb = <?//= $value['price'] ?>// * e.target.value;
                                //    const format = numb.toString().split('').reverse().join('');
                                //    const convert = format.match(/\d{1,3}/g);
                                //    const total = 'Rp ' + convert.join('.').split('').reverse().join('')
                                //    document.getElementById("totaljumlah").innerHTML = total
                                //    return total;
                                //}
                            </script>
                        </form>
                    </div>
                </div>
                <div style="margin-top: 50px;">
                    <div class="p-2">
                        <ul class="nav nav-pills">
                            <li><a class="nav-item nav-link active" href="#deskripsi" data-toggle="tab" id="rincian-produk">Rincian Template</a></li>
                            <li><a class="nav-item nav-link" href="#deskripsiHarga" data-toggle="tab">Harga</a></li>
                            <li><a class="nav-item nav-link" href="#sumberUpload" data-toggle="tab">Ketentuan</a></li>
                            <li><a class="nav-item nav-link" href="#ulasan" data-toggle="tab" id="ulasan-tab">Ulasan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="garis"></div>
                    <div class="card-body" style="min-height: 700px;">
                        <div class="tab-content">

                            <div class="active tab-pane desc" id="deskripsi">
                                <?php if(isset($value['description'])) echo $value['description']; ?>
                            </div>

                            <div class="tab-pane" id="deskripsiHarga">
                                <div class="row">
                                    <div class="col-md-3" id="table-range"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="padding:5px 10px" id="range-atb2">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>

                            <div class=" tab-pane" id="sumberUpload" style="font-size: 14px;">
                                <ul>
                                    <li>Jenis file: TIFF, JPG, PNG, PDF, ZIP, RAR.</li>
                                    <li>Ukuran File Upload maksimal 20 Mb, lebih dari 20 Mb menggunakan share link.</li>
                                    <li>Mohon dicek detail: design, text, ejaan, warna, background, informasi, batas margin.</li>
                                    <li>Mohon file yang anda kirim sudah Ready to print, file yang belum siap akan mempengaruhi waktu produksi.</li>
                                    <li>Mohon file yang anda kirim rasio ukurannya sesuai dengan cetakan, misalnya file 1x1 dan anda pilih ukuran 2x1 maka akan kita tarik di ukuran 2x1</li>
                                    <li>Setiap file yang dicetak sudah dicek terlebih dahulu sesuai keterangan yang di order</li>


                                </ul>
                            </div>

                            <div class="tab-pane" id="ulasan">
                                <div class="offer-dedicated-body-left">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade active show" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                                            <div class="bg-white rounded shadow-sm p-4 mb-4 detail-review">
                                                <div class="reviews-members pt-4 pb-4">
                                                    <div class="media">
                                                        <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/cust.png" class="mr-3 rounded-pill"></a>
                                                        <div class="media-body">
                                                            <div class="reviews-members-header">
                                                                <h6 class="mb-1 text-black">
                                                                    Eric
                                                                </h6>
                                                                <div class="tgl-rate">
                                                                    Sabtu, 11 September 2021
                                                                </div>
                                                                <div class="rating-product">
                                                                    <div class="Stars2" style="--rating: 5;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="reviews-members-body text-justify mt-2">
                                                                <p>
                                                                    Template Mantap
                                                                </p>
                                                            </div>
                                                            <div class="reviews-members pt-2 pb-4">
                                                                <div class="media">
                                                                    <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/p.png" class="mr-3 rounded-pill"></a>
                                                                    <div class="media-body">
                                                                        <div class="reviews-members-header">
                                                                            <h6 class="text-black">Indoprinting</h6>
                                                                        </div>
                                                                        <div class="reviews-members-body text-justify mt-2  ">
                                                                            <p>
                                                                                Terima kasih telah berbelanja di indoprinting Official. Bagikan link toko kami www.indoprinting.co.id kepada teman-teman Anda dan favoritkan Toko kami untuk terus update mengenai stok dan produk terbaru
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="reviews-members pt-4 pb-4">
                                                    <div class="media">
                                                        <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/cust.png" class="mr-3 rounded-pill"></a>
                                                        <div class="media-body">
                                                            <div class="reviews-members-header">
                                                                <h6 class="mb-1 text-black">
                                                                    Nova Ayu
                                                                </h6>
                                                                <div class="tgl-rate">
                                                                    Sabtu, 13 November 2021
                                                                </div>
                                                                <div class="rating-product">
                                                                    <div class="Stars2" style="--rating: 5;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="reviews-members-body text-justify mt-2">
                                                                <p>

                                                                </p>
                                                            </div>
                                                            <div class="reviews-members pt-2 pb-4">
                                                                <div class="media">
                                                                    <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/p.png" class="mr-3 rounded-pill"></a>
                                                                    <div class="media-body">
                                                                        <div class="reviews-members-header">
                                                                            <h6 class="text-black">Indoprinting</h6>
                                                                        </div>
                                                                        <div class="reviews-members-body text-justify mt-2  ">
                                                                            <p>
                                                                                Terima kasih telah berbelanja di indoprinting Official. Bagikan link toko kami www.indoprinting.co.id kepada teman-teman Anda dan favoritkan Toko kami untuk terus update mengenai stok dan produk terbaru
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="reviews-members pt-4 pb-4">
                                                    <div class="media">
                                                        <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/cust.png" class="mr-3 rounded-pill"></a>
                                                        <div class="media-body">
                                                            <div class="reviews-members-header">
                                                                <h6 class="mb-1 text-black">
                                                                    Nova Ayu
                                                                </h6>
                                                                <div class="tgl-rate">
                                                                    Sabtu, 13 November 2021
                                                                </div>
                                                                <div class="rating-product">
                                                                    <div class="Stars2" style="--rating: 5;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="reviews-members-body text-justify mt-2">
                                                                <p>

                                                                </p>
                                                            </div>
                                                            <div class="reviews-members pt-2 pb-4">
                                                                <div class="media">
                                                                    <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/p.png" class="mr-3 rounded-pill"></a>
                                                                    <div class="media-body">
                                                                        <div class="reviews-members-header">
                                                                            <h6 class="text-black">Indoprinting</h6>
                                                                        </div>
                                                                        <div class="reviews-members-body text-justify mt-2  ">
                                                                            <p>
                                                                                Terima kasih telah berbelanja di indoprinting Official. Bagikan link toko kami www.indoprinting.co.id kepada teman-teman Anda dan favoritkan Toko kami untuk terus update mengenai stok dan produk terbaru
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="reviews-members pt-4 pb-4">
                                                    <div class="media">
                                                        <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/cust.png" class="mr-3 rounded-pill"></a>
                                                        <div class="media-body">
                                                            <div class="reviews-members-header">
                                                                <h6 class="mb-1 text-black">
                                                                    Nova Ayu
                                                                </h6>
                                                                <div class="tgl-rate">
                                                                    Sabtu, 13 November 2021
                                                                </div>
                                                                <div class="rating-product">
                                                                    <div class="Stars2" style="--rating: 5;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="reviews-members-body text-justify mt-2">
                                                                <p>

                                                                </p>
                                                            </div>
                                                            <div class="reviews-members pt-2 pb-4">
                                                                <div class="media">
                                                                    <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/p.png" class="mr-3 rounded-pill"></a>
                                                                    <div class="media-body">
                                                                        <div class="reviews-members-header">
                                                                            <h6 class="text-black">Indoprinting</h6>
                                                                        </div>
                                                                        <div class="reviews-members-body text-justify mt-2  ">
                                                                            <p>
                                                                                Terima kasih telah berbelanja di indoprinting Official. Bagikan link toko kami www.indoprinting.co.id kepada teman-teman Anda dan favoritkan Toko kami untuk terus update mengenai stok dan produk terbaru
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="reviews-members pt-4 pb-4">
                                                    <div class="media">
                                                        <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/cust.png" class="mr-3 rounded-pill"></a>
                                                        <div class="media-body">
                                                            <div class="reviews-members-header">
                                                                <h6 class="mb-1 text-black">
                                                                    Eric
                                                                </h6>
                                                                <div class="tgl-rate">
                                                                    Kamis, 24 Pebruari 2022
                                                                </div>
                                                                <div class="rating-product">
                                                                    <div class="Stars2" style="--rating: 5;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="reviews-members-body text-justify mt-2">
                                                                <p>

                                                                </p>
                                                            </div>
                                                            <div class="reviews-members pt-2 pb-4">
                                                                <div class="media">
                                                                    <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/p.png" class="mr-3 rounded-pill"></a>
                                                                    <div class="media-body">
                                                                        <div class="reviews-members-header">
                                                                            <h6 class="text-black">Indoprinting</h6>
                                                                        </div>
                                                                        <div class="reviews-members-body text-justify mt-2  ">
                                                                            <p>
                                                                                Terima kasih telah berbelanja di indoprinting Official. Bagikan link toko kami www.indoprinting.co.id kepada teman-teman Anda dan favoritkan Toko kami untuk terus update mengenai stok dan produk terbaru
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="reviews-members pt-4 pb-4">
                                                    <div class="media">
                                                        <a href="#"><img alt="" src="https://indoprinting.co.id/assets/images/logo/cust.png" class="mr-3 rounded-pill"></a>
                                                        <div class="media-body">
                                                            <div class="reviews-members-header">
                                                                <h6 class="mb-1 text-black">
                                                                    Ulfa Dyanasari
                                                                </h6>
                                                                <div class="tgl-rate">
                                                                    Kamis, 24 Pebruari 2022
                                                                </div>
                                                                <div class="rating-product">
                                                                    <div class="Stars2" style="--rating: 5;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="reviews-members-body text-justify mt-2">
                                                                <p>
                                                                    oke
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="https://indoprinting.co.id/assets/js/product_detail.js"></script>
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
<!--        <div class="lumise-product">-->
<!--            <div class="container">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-5">-->
<!--                        <div class="product-img">-->
<!--                            <figure><img src="--><?php //echo $thumbnail_url;?><!--" alt=""></figure>    -->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-7">-->
<!--                        <div class="product-detail">-->
<!--                            --><?php //if(isset($value['name'])) echo '<h1>'.$value['name'].'</h1>'; ?>
<!--                            --><?php //if($value['price'] != 0): ?>
<!--                                --><?php //if(isset($value['price'])) echo '<p class="price">'.$lumise->lib->price($value['price']).'</p>'; ?>
<!--                            --><?php //else: ?>
<!--                                <h3 style="color: #fb8c00"><small>Start</small> Rp 20.000</h3>-->
<!--                            --><?php //endif; ?>
<!--                            --><?php //if(isset($value['description']) && !empty($value['description'])) echo '<p class="desc">'.$value['description'].'</p>'; ?>
<!--                            <form style="margin-top: 18px;">-->
<!--                                <input type="number" step="1" min="1" max="" name="quantity" value="1" inputmode="numeric">-->
<!--                                --><?php //if($has_template && false == true):?>
<!--                                    <a href="--><?php //echo $lumise->cfg->url.'add-cart.php?product_base='.$value['id']; ?><!--" class="lumise-add">-->
<!--	                                    --><?php //echo $lumise->lang('Add to cart'); ?>
<!--	                                </a>-->
<!--                                --><?php //endif; ?>
<!--                                <a href="--><?php //echo $lumise->cfg->tool_url.'?product_base='.$value['id']; ?><!--" class="lumise-custom">-->
<!--	                                --><?php //echo $lumise->lang('Customize'); ?>
<!--                                </a>-->
<!--                            </form>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="container">-->
<!--                <div class="lumise-list lumise-related">-->
<!--                    <h2> --><?php //echo $lumise->lang('More products'); ?><!--</h2>-->
<!--                    --><?php //LumiseView::products($data['rows']); ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<?php include(theme('footer.php')); ?>

<script type="text/javascript">

</script>