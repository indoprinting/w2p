<?php
require('autoload.php');
global $lumise;

$dt_order = isset($_REQUEST['order']) && !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'name_asc';
$current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;
$cate_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

$order_cfg = explode('_', $dt_order);
$orderby = "`{$order_cfg[0]}`";
$ordering = "{$order_cfg[1]}";

$search_filter = array(
    'keyword' => ''
,    'fields' => 'name'
);

$default_filter = array(
    'type' => '',
);
$per_page = 8;
$start = ( $current_page - 1 ) * $per_page;

if (isset($cate_id) && !empty($cate_id))
    $data = $lumise->lib->get_by_category($cate_id, $orderby, $ordering, $per_page, $start, 'products', array('active'=> 1));
else
    $data = $lumise->lib->get_rows('products', $search_filter, $orderby, $ordering, $per_page, $start, array('active'=> 1), '');

$data['total_page'] = ceil($data['total_count'] / $per_page);
$config = array(
    'current_page'  => $current_page,
    'total_record'  => $data['total_count'],
    'total_page'    => $data['total_page'],
    'limit'         => $per_page,
    'link_full'     => $lumise->cfg->url.'products.php?tpage={page}'.(!empty($cate_id) ? '&category_id='.$cate_id : ''),
    'link_first'    => $lumise->cfg->url.'products.php'.(!empty($cate_id) ? '?category_id='.$cate_id : ''),
);
$lumise_pagination = new lumise_pagination();
$lumise_pagination->init($config);

$categories = $lumise->lib->get_categories('products');
$cat_options = array('' => '-- Categories --');
foreach($categories as $cat){
    $cat_options[$cat['id']] = $cat['name'];
}

$filters = array(
    'category_id' => array(
        'type' => 'dropdown',
        'options' => $cat_options,
        'default' => '',
        'val' => $cate_id
    ),
    'order' => array(
        'type' => 'dropdown',
        'options' => array(
            '' => '-- Sortby --',
            'name_asc' => 'Name Asc',
            'name_desc' => 'Name Desc',
            'order_asc' => 'Order Asc',
            'order_desc' => 'Order Desc',
        ),
        'default' => '',
        'val' => $dt_order
    )
);


function rupiah($angka){

    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
    return $hasil_rupiah;

}
?>
<!-- ======= Top Bar ======= -->

<div class="content">

    <main>
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container-fluid">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li>Templates</li>
                </ol>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h2>
                            Template Web to Print
                        </h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <form method="GET" id="myForm">
                            <input type="hidden" name="_token" value="dHU50EX1TKVbT8waWYpVsMPs1KQKTvIr5vaVBCLq">                            <select class="form-control" name="sort" id="sort" style="float: right;width:175px">
                                <option value="name,asc">Urutkan : A - Z</option>
                                <option value="name,desc">Urutkan : Z - A</option>
                                <option value="min_price,asc">Termurah</option>
                                <option value="min_price,desc">Termahal</option>
                                <option value="best_seller_sum_qty,desc">Terlaris</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section id="category" class="category">
            <div class="container-fluid">
                <div class="product-list">
                    <div class="row">

                        <?php $templates = mysqli_query($w2p, "SELECT * FROM nsm_templates WHERE active = 1"); ?>
                        <?php if(mysqli_num_rows($templates)>0) { ?>
                        <?php $no = 1; while($data = mysqli_fetch_array($templates)){
                            ?>
                            <div class="icon-box">
                                <div class="box">
                                    <div class="frame">
                                        <a href="">
                                            <div class="icon"><img src=" <?= $data['screenshot'] ?>"></div>
                                            <div class="text">
                                                <?= $data['name'] ?>
                                            </div>
                                            <div class="price">Start
                                                <b>
                                                    <?= rupiah($data['price']) ?>
                                                </b>
                                            </div>
                                            <div class="rating-sold">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>

                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php $no++; } ?>
                        <?php } ?>

                    </div>
                </div>
                <hr>

            </div>
        </section>
    </main>
    <script>
        $(document).ready(function() {
            let sort = "name,asc";
            $("#sort").on('change', function() {
                $('#myForm').submit();
            });

            $("#sort").val(sort).find(`option[value="${sort}"]`).attr('selected', true);
        });
    </script>
</div>

