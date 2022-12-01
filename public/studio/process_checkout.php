<?php 
	
require('autoload.php');
global $lumise, $lumise_helper;

if(isset($_POST['action'])){

    // Save to personal website
    $data = $lumise->connector->save_order();
    if(isset($data['order_id'])){
		$lumise_helper->process_payment($data['order_data']);
        $lumise_helper->redirect($lumise->cfg->url. 'success.php?order_id='. $data['order_id']);
    } else {
	    print_r($data);
	    return;
    }

    // Save to personal w2p website
//    $data = $lumise->connector->save_order_toWebsite();
//    if(isset($data['order_id'])){
//        $lumise_helper->process_payment($data['order_data']);
//        $lumise_helper->redirect($lumise->cfg->url. 'success.php?order_id='. $data['order_id']);
//    } else {
//        print_r($data);
//        return;
//    }
}
$lumise_helper->redirect($lumise->cfg->url. 'checkout.php');
