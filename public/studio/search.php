<?php
require('autoload.php');
global $lumise;
include(theme('header.php'));

$servername='localhost';
$username='idp_w2p';
$password="Dur14n100$";
$dbname = "idp_w2p";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(isset($_POST["cari"])){
    $search = $_POST['keyword'];
    $search_template = mysqli_query($conn, "SELECT * from nsm_products where name LIKE '%$search%' ORDER BY id DESC  ");
} else {
    $search_template = mysqli_query($conn, "SELECT * from nsm_products ORDER BY id DESC  ");
}
?>
<div class="content">

    <main>
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container-fluid">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li><a href="https://indoprinting.co.id/studio/">IDP Design Studio</a></li>
                    <li><?= isset($_POST['keyword'])? $_POST['keyword'] : 'Semua Template' ?></li>
                </ol>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h2>
                            <?= isset($_POST['keyword'])? $_POST['keyword'] : 'Semua Template' ?>
                        </h2>
                    </div>
                </div>
            </div>
        </section>
        <section id="category" class="category">
            <section class="container-fluid">
                <div class="product-list">
                    <div class="row">
                        <?php $no = 1; foreach ($search_template as $value) :
                            ?>
                            <div class="icon-box">
                                <div class="box">
                                    <div class="frame">
                                        <a href="<?php echo $lumise->cfg->url.'product?product_id='.$value['id']; ?>">
                                            <div class="icon"><img src="<?php echo $value['thumbnail_url'];?>"></div>
                                            <div class="text">
                                                <?php if(isset($value['name'])) echo $value['name'];?>
                                            </div>
                                            <div class="price">Start
                                                <b>
                                                    <?php if($value['price'] != 0): ?>
                                                        <?php if(isset($value['name'])) echo $lumise->lib->price($value['price']);?>
                                                    <?php else: ?>
                                                        Free
                                                    <?php endif; ?>
                                                </b>
                                            </div>
                                            <div class="rating-sold">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <br />
                                                <a href="<?php echo $lumise->cfg->tool_url.'?product_base='.$value['id']; ?>" class="lumise-custom">
                                                    <?php echo $lumise->lang('Design Custom'); ?>
                                                </a>

                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </section>
        <hr />
        <?php include(theme('footer.php')); ?>
