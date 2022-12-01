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
$per_page = 20;
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

$page_title = 'Templates';
include(theme('header.php'));

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


?>
<style>
    .lumise_pagination {
        float: left;
        width: 100%;
        margin-top: 20px;
    }

    .lumise_pagination ul {
        float: right;
        background: #fff;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .lumise_pagination ul li {
        float: left;
        margin-bottom: 5px;
    }

    .lumise_pagination ul li a, .lumise_pagination ul li span {
        display: block;
        width: 35px;
        height: 34px;
        line-height: 34px;
        text-align: center;
        border: 1px solid #e4e9f0;
        margin-left: -1px;
        color: #74708d;
    }

    .lumise_pagination ul li a:hover {
        background: #f6f6f6;
    }

    .lumise_pagination ul li span {
        background: #e96b56;
        color: #fff;
        border-color: #e96b56;
    }

    .lumise_pagination ul li span.none {
        cursor: not-allowed;
        background: #fff;
        border-color: #e4e9f0;
        color: #74708d;
    }

    .lumise_pagination ul li:last-child > span, .lumise_pagination ul li:last-child > a {
        border-right: 1px solid #e4e9f0;
        border-radius: 0 2px 2px 0;
    }

    .lumise_pagination ul li:first-child > span, .lumise_pagination ul li:first-child > a {
        border-radius: 2px 0 0 2px;
    }

    .lumise_pagination p {
        margin: 0;
        float: left;
    }
</style>
<main>
    <?php LumiseView::breadcrumbs_categories(); ?>
    <section id="category" class="category">
        <section class="container-fluid">
            <div class="product-list">
                <div class="row">
                    <?php LumiseView::products($data['rows']); ?>
<!--                    <form class="" action="products.php" method="get">-->
<!--                        --><?php //LumiseView::filter($data, $filters); ?>
<!--                    </form>-->
                </div>
            </div>
            <br />
            <div class="container">
                <div class="lumise_pagination">
                    <?php echo $lumise_pagination->pagination_html(); ?>
                </div>
            </div>
        </section>
    </section>
    <br />
    <div class="text-center">
        <nav aria-label="Page navigation">
            <ul class='pagination model1'>

            </ul>
        </nav>
    </div>
    <hr />
</main>
<?php include(theme('footer.php'));?>
