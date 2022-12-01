<?php
/**
 *
 */
class LumiseView {

    function __construct(){
    }

    public static function products($data){
        global $lumise, $lumise_helper;
        ?>

        <?php foreach ($data as $key => $value) {
            $thumbnail_url = 'https://indoprinting.co.id/assets/images/logo/favicon.png';
            if(!empty($value['thumbnail_url']))
                $thumbnail_url = $value['thumbnail_url'];

            $has_template = $lumise_helper->has_template($value);
            ?>
            <div class="icon-box">
                <div class="box">
                    <div class="frame">
                        <a href="<?php echo $lumise->cfg->url.'product?product_id='.$value['id']; ?>">
                            <div class="icon"><img src="<?php echo $thumbnail_url;?>"></div>
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
                                <?php if($has_template && false == true):?>
                                    <a href="<?php echo $lumise->cfg->url.'add-cart.php?product_base='.$value['id']; ?>" class="lumise-add">
                                        <?php echo $lumise->lang('Add to cart'); ?>
                                    </a>
                                <?php endif;?>
                                <a href="<?php echo $lumise->cfg->tool_url.'?product_base='.$value['id']; ?>" class="lumise-custom">
                                    <?php echo $lumise->lang('Design Custom'); ?>
                                </a>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
    }

    public static function templates($data){
        global $lumise;
        ?>
        <?php foreach ($data as $key => $value) {
            $thumbnail_url = 'https://indoprinting.co.id/assets/images/logo/favicon.png';
            if(!empty($value['screenshot']))
                $thumbnail_url = $value['screenshot'];
            ?>
            <div class="icon-box">
                <div class="box">
                    <div class="frame">
                        <a href="<?php echo $lumise->cfg->url.'product?product_id='.$value['id']; ?>">
                            <div class="icon"><img src="<?php echo $thumbnail_url;?>"></div>
                            <div class="text">
                                <?php if(isset($value['name'])) echo '<h3>'.$value['name'].'</h3>';?>
                            </div>
                            <div class="price">Start
                                <b>
                                    <?php if($value['price'] != 0): ?>
                                        <?php if(isset($value['name'])) echo '<span class="lumise-price">'.$lumise->lib->price($value['price']).'</span>';?>
                                    <?php else: ?>
                                        <h3 style="color: #fb8c00; text-align: left"><small>Start</small> Rp 20.000</h3>
                                    <?php endif; ?>
                                </b>
                            </div>
                            <div class="rating-sold">
                                <?php if($has_template && false == true):?>
                                    <a href="<?php echo $lumise->cfg->url.'add-cart.php?product_base='.$value['id']; ?>" class="lumise-add">
                                        <?php echo $lumise->lang('Add to cart'); ?>
                                    </a>
                                <?php endif;?>
                                <a href="<?php echo $lumise->cfg->tool_url.'?product_base='.$value['id']; ?>" class="lumise-custom">
                                    <?php echo $lumise->lang('Customize'); ?>
                                </a>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
    }

    public static function categories($limit = 5){
        global $lumise;
        $categories = $lumise->lib->get_categories('products', 0, '`order` DESC');
        $count = 0;
        if(count($categories)>0):
            ?>
            <section id="category" class="category">
                <section class="container-fluid">
                    <h5 class="category-list">
                        Kategori Template
                    </h5>
                    <div class="product-list">
                        <div class="row">
                            <?php
                            foreach ($categories as $data) {

                                $thumbnail_url = 'https://indoprinting.co.id/assets/images/logo/favicon.png';
                                if(!empty($data['thumbnail']))
                                    $thumbnail_url = $data['thumbnail'];
                                ?>
                                <div class="icon-box">
                                    <div class="box">
                                        <div class="frame">
                                            <a href="<?php echo $lumise->cfg->url.'products?category_id='.$data['id']; ?>">
                                                <div class="icon"><img src="<?php echo $thumbnail_url;?>"></div>
                                                <div class="text">
                                                    <?php if(isset($data['name'])) echo $data['name']?>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php $count++; if($limit == $count) break; } ?>
                        </div>
                    </div>
                    <hr>

                    </div>
                </section>
            </section>
            </main>
            </div>
        <?php
        endif;
    }

    public static function search_product($limit = 15){
        global $lumise;
        $servername='localhost';
        $username='idp_w2p';
        $password="Dur14n100$";
        $dbname = "idp_w2p";
        $conn=mysqli_connect($servername,$username,$password,"$dbname");
        if(isset($_POST["cari"])){
            $search = $_POST['keyword'];
            $search_template = mysqli_query($conn, "SELECT * from nsm_products where name = '".$_GET["product_name"]."'  ");
        } else {
            $search_template = mysqli_query($conn, "SELECT * from nsm_products where name = '".$_GET["product_name"]."'  ");
        }
        $no = 1;
        foreach ($search_template as $value) {
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
                                        Rp 20.000
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
                                <?php if($has_template && false == true):?>
                                    <a href="<?php echo $lumise->cfg->url.'add-cart.php?product_base='.$value['id']; ?>" class="lumise-add">
                                        <?php echo $lumise->lang('Add to cart'); ?>
                                    </a>
                                <?php endif;?>
                                <a href="<?php echo $lumise->cfg->tool_url.'?product_base='.$value['id']; ?>" class="lumise-custom">
                                    <?php echo $lumise->lang('Design Custom'); ?>
                                </a>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public static function navbar_categories($limit = 15){
        global $lumise;
        $categories = $lumise->lib->get_categories('products', 0, '`order` DESC');
        $count = 0;
        if(count($categories)>0):
            ?>
            <div class="container-fluid category-nav">
                <div class="row">
<!--                    <a class="border-nav" href="--><?php //echo $lumise->cfg->url.'products.php' ?><!--">-->
<!--                        <div>-->
<!--                            Semua Template-->
<!--                        </div>-->
<!--                    </a>-->
                    <?php foreach ($categories as $data) { ?>
                        <a class="border-nav" href="<?php echo $lumise->cfg->url.'products.php?category_id='.$data['id']; ?>">
                            <div>
                                <?php if(isset($data['name'])) echo $data['name']?>
                            </div>
                        </a>
                        <?php $count++; if($limit == $count) break; } ?>
                </div>
            </div>
        <?php
        endif;
    }

    public static function breadcrumbs_categories($limit = 15){
        global $lumise;
        $servername='localhost';
        $username='idp_w2p';
        $password="Dur14n100$";
        $dbname = "idp_w2p";
        $conn=mysqli_connect($servername,$username,$password,"$dbname");
        $categories = mysqli_query($conn, "SELECT * from nsm_categories where type = 'products' and id = '".$_GET["category_id"]."' ");
        ?>
            <section id="breadcrumbs" class="breadcrumbs">
                <div class="container-fluid">
                    <ol>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="https://indoprinting.co.id/studio/">IDP Design Studio</a></li>
                        <?php if ($_GET["category_id"] == null) : ?>
                                <li>Semua Template</li>
                        <?php else: ?>
                            <?php foreach ($categories as $category) : ?>
                                <li>Template <?= $category['name'] ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ol>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <?php if ($_GET["category_id"] == null) : ?>
                                <h2>
                                    Semua Template
                                </h2>
                            <?php else: ?>
                                <?php foreach ($categories as $category) : ?>
                                    <h2>
                                        Template <?= $category['name'] ?>
                                    </h2>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php
                        $servername='localhost';
                        $username='idp_w2p';
                        $password="Dur14n100$";
                        $dbname = "idp_w2p";
                        $conn=mysqli_connect($servername,$username,$password,"$dbname");
                        $categories = mysqli_query($conn, "SELECT * from nsm_categories where type = 'products' and parent = '".$_GET["category_id"]."' ");
                        $limits = mysqli_query($conn, "SELECT * from nsm_categories where type = 'products' and parent = '".$_GET["category_id"]."' LIMIT 1 ");
                        ?>
                        <?php foreach ($limits as $limit) : ?>
                            <?php if ($limit['parent'] != 0) : ?>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <select class="form-control" name="category_id" id="Myselect" style="float: right;width:220px">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $("select").change(function(){
                                            var myvalue = $(this).val();
                                            location.href = "https://indoprinting.co.id/studio/products.php?category_id="+myvalue;
                                        });
                                    });
                                </script>
                            <?php else : ?>
<!--                                <div class="col-md-6 col-sm-12">-->
<!--                                    <select class="form-control" name="category_id" id="Myselect" style="float: right;width:175px">-->
<!--                                        <option value="asc">asc</option>-->
<!--                                        <option value="desc">desc</option>-->
<!--                                    </select>-->
<!--                                </div>-->
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <?php
        }

    public function message(){

        $lumise_msg = $this->get_session('lumise_msg');

        if (isset($lumise_msg['status']) && $lumise_msg['status'] == 'error') { ?>

            <div class="tsd_message err">
                <?php foreach ($lumise_msg['errors'] as $val) {
                    echo '<em class="tsd_err"><i class="fa fa-times"></i>' . $val . '.</em>';
                } ?>
            </div>

        <?php }

        if (isset($lumise_msg['status']) && $lumise_msg['status'] == 'success') { ?>

            <div class="tsd_message">
                <?php
                echo '<em class="tsd_suc"><i class="fa fa-check"></i>'.(isset($lumise_msg['msg'])? $lumise_msg['msg'] : $lumise->lang('Your data has been successfully saved') ).'</em>';

                ?>
            </div>

        <?php }

        $lumise_msg = array('status' => '');
        $this->set_session('lumise_msg', $lumise_msg);

    }

    public static function filter($data, $filters){


        ?>
        <div class="col-md-6 col-sm-12">
            <?php
            foreach ($filters as $name => $cfg) {
                ?>
                <div class="lumise-filter-<?php echo $name;?>">
                    <?php
                    switch ($cfg['type']) {
                        case 'dropdown':
                            ?>
                            <select class="form-control" name="<?php echo $name;?>" style="float: right;width:175px">
                                <?php foreach($cfg['options'] as $key => $val):?>
                                    <option value="<?php echo $key;?>"<?php echo (isset($cfg['val']) && $cfg['val'] == $key)? ' selected="selected"':''?>><?php echo $val;?></option>
                                <?php endforeach;?>
                            </select>
                            <?php
                            break;

                        default:
                            # code...
                            break;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}