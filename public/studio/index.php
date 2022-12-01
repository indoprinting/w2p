<?php

require('autoload.php');

global $lumise;

$orderby  = '`order`';
$ordering = 'asc';
$dt_order = 'name_asc';
$current_page = isset($_GET['tpage']) ? $_GET['tpage'] : 1;

$search_filter = array(
    'keyword' => '',
    'fields' => 'name'
);

$default_filter = array(
    'type' => '',
);
$per_page = 20;
$start = ( $current_page - 1 ) * $per_page;
$data = $lumise->lib->get_rows('products', $search_filter, $orderby, $ordering, $per_page, $start, array('active'=> 1), '');

include(theme('header.php'));

?>
<div class="content">

    <main>
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container-fluid">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li>IDP Design Studio</li>
                </ol>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h2>
                            IDP Design Studio
                        </h2>
                    </div>
                </div>
            </div>
        </section>
        <br/>
<!--        --><?php //LumiseView::categories(); ?>
        <section id="category" class="category">
            <section class="container-fluid">
                <h5 class="category-list">
                    Template Terbaru
                </h5>
                <div class="product-list">
                    <div class="row">
                        <?php LumiseView::products($data['rows']); ?>
                    </div>
                </div>
            </section>
        </section>
        <hr />
        <?php include(theme('footer.php')); ?>
